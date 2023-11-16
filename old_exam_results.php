<?php
session_start();

include "header.php";
include "connection.php";
if (!isset($_SESSION["username"])) {
?>
    <script type="text/javascript">
        window.location = "login.php";
    </script>
<?php
}
?>

<div class="row" style="margin: 0px; padding:0px; margin-bottom: 50px; background: linear-gradient(to right, #3498db, #9b59b6, #e74c3c);">

    <div class="col-lg-8 col-lg-push-2" style="min-height: 500px; background: linear-gradient(to right, #3498db, #9b59b6, #e74c3c);">

        <center>
            <h1>Resultados de exames anteriores</h1>
        </center>

        <!-- Adicionando o formulário de filtro -->
        <form method="POST" action="">
            <label for="exam_type">Filtrar por Tipo de Exame:</label>
            <select name="exam_type" id="exam_type">
                <option value="">Todos</option>
                <?php
                // Obtendo os tipos de exame do banco de dados
                $examTypeQuery = mysqli_query($link, "SELECT DISTINCT exam_type FROM exam_results");
                while ($examTypeRow = mysqli_fetch_array($examTypeQuery)) {
                    $selected = isset($_POST['exam_type']) && $_POST['exam_type'] == $examTypeRow['exam_type'] ? 'selected' : '';
                    echo "<option value='" . $examTypeRow['exam_type'] . "' $selected>" . $examTypeRow['exam_type'] . "</option>";
                }
                ?>
            </select>

            <label for="percent_range">Filtrar por % de Acerto:</label>
            <select name="percent_range" id="percent_range">
                <option value="">Todos</option>
                <option value="0-25">0-25%</option>
                <option value="26-50">26-50%</option>
                <option value="51-75">51-75%</option>
                <option value="76-100">76-100%</option>
            </select>

            <input type="submit" value="Filtrar">
        </form>

        <?php
        // Adicionando a lógica de filtro
        $whereClause = " WHERE username='$_SESSION[username]'";

        if (isset($_POST['exam_type']) && !empty($_POST['exam_type'])) {
            $examTypeFilter = $_POST['exam_type'];
            $whereClause .= " AND exam_type='$examTypeFilter'";
        }

        if (isset($_POST['percent_range']) && !empty($_POST['percent_range'])) {
            $percentRangeFilter = $_POST['percent_range'];
            $percentRangeArray = explode('-', $percentRangeFilter);

            $minPercent = $percentRangeArray[0];
            $maxPercent = $percentRangeArray[1];

            $whereClause .= " AND (correct_answer / total_question * 100) BETWEEN $minPercent AND $maxPercent";
        }

        $res = mysqli_query($link, "SELECT * FROM exam_results $whereClause ORDER BY id DESC");
        $count = mysqli_num_rows($res);

        if ($count == 0) {
        ?>
            <center>
                <h1>Nenhum resultado encontrado</h1>
            </center>
        <?php
        } else {
            echo "<table class='table table-bordered'>";
            echo "<tr style='background-color: #006df0; color:white'>";
            echo "<th>";
            echo "Usuário";
            echo "</th>";
            echo "<th>";
            echo "Tipo de exame";
            echo "</th>";
            echo "<th>";
            echo "Questões totais";
            echo "</th>";
            echo "<th>";
            echo "Respostas corretas";
            echo "</th>";
            echo "<th>";
            echo "Respostas erradas";
            echo "</th>";
            echo "<th>";
            echo "% de Acerto";
            echo "</th>";
            echo "<th>";
            echo "Tempo do exame";
            echo "</th>";
            echo "</tr>";

            while ($row = mysqli_fetch_array($res)) {
                echo "<tr>";
                echo "<td>";
                echo $row["username"];
                echo "</td>";
                echo "<td>";
                echo $row["exam_type"];
                echo "</td>";
                echo "<td>";
                echo $row["total_question"];
                echo "</td>";
                echo "<td>";
                echo $row["correct_answer"];
                echo "</td>";
                echo "<td>";
                echo $row["wrong_answer"];
                echo "</td>";

                // Calcular e exibir a coluna "% de Acerto"
                $percentCorrect = ($row["correct_answer"] / $row["total_question"]) * 100;
                echo "<td>";
                echo round($percentCorrect, 2) . "%";
                echo "</td>";

                echo "<td>";
                echo $row["exam_time"];
                echo "</td>";

                echo "</tr>";
            }

            echo "</table>";
        }
        ?>
    </div>

</div>

<?php
include "footer.php";
?>
