<?php
session_start();
include "header.php";
include "../connection.php";

if (!isset($_SESSION["empresa"])) {
?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
<?php
}

?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Resultados dos Exames</h1>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 col-lg-push-3" style="min-height: 500px; background-color: white;">

                            <center>
                                <h1>Resultados de exames anteriores</h1>
                            </center>

                            <?php
                            $count = 0;

                            // Adicionando lógica para obter os parâmetros de ordenação e filtro, se definidos
                            $orderColumn = isset($_GET['order_column']) ? $_GET['order_column'] : 'exam_results.id';
                            $orderDirection = isset($_GET['order_direction']) ? $_GET['order_direction'] : 'desc';
                            $examTypeFilter = isset($_GET['exam_type']) ? $_GET['exam_type'] : '';
                            $usernameFilter = isset($_GET['username_filter']) ? $_GET['username_filter'] : '';

                            // Ajustando a lógica de ordenação para % de Acerto
                            if ($orderColumn == 'percentCorrect') {
                                $orderColumn = 'correct_answer / total_question'; // ou o nome real das colunas no seu banco de dados
                            }

                            $whereClause = '';
                            if (!empty($examTypeFilter)) {
                                $whereClause = " WHERE exam_results.exam_type = '$examTypeFilter'";
                            }

                            if (!empty($usernameFilter)) {
                                $whereClause .= " AND exam_results.username LIKE '%$usernameFilter%'";
                            }

                            $res = mysqli_query($link, "SELECT exam_results.*, exam_category.creationdate
                                                         FROM exam_results 
                                                         LEFT JOIN exam_category ON exam_results.exam_type = exam_category.category
                                                         $whereClause
                                                         ORDER BY $orderColumn $orderDirection");
                            $count = mysqli_num_rows($res);

                            if ($count == 0) {
                            ?>
                                <center>
                                    <h1>Nenhum resultado encontrado</h1>
                                </center>
                            <?php
                            } else {
                                // Adicionando formulário para escolher a coluna, a ordem e o filtro
                                ?>
                                <form method="GET" action="">
                                    <label for="order_column">Escolha a Coluna:</label>
                                    <select name="order_column" id="order_column">
                                        <option value="username">Usuário</option>
                                        <option value="exam_type">Tipo de exame</option>
                                        <option value="total_question">Questões totais</option>
                                        <option value="correct_answer">Respostas corretas</option>
                                        <option value="wrong_answer">Respostas erradas</option>
                                        <option value="percentCorrect">% de acerto</option>
                                        <option value="exam_time">Data Realizada</option>
                                        <option value="creationdate">Criação de Formulário</option>
                                    </select>
                                    <label for="order_direction">Escolha a Ordem:</label>
                                    <select name="order_direction" id="order_direction">
                                        <option value="desc">Decrescente</option>
                                        <option value="asc">Crescente</option>
                                    </select>

                                    <label for="exam_type">Filtrar por Tipo de Exame:</label>
                                    <select name="exam_type" id="exam_type">
                                        <option value="">Todos</option>
                                        <?php
                                        // Obtendo os tipos de exame do banco de dados
                                        $examTypeQuery = mysqli_query($link, "SELECT DISTINCT exam_type FROM exam_results");
                                        while ($examTypeRow = mysqli_fetch_array($examTypeQuery)) {
                                            $selected = ($examTypeFilter == $examTypeRow['exam_type']) ? 'selected' : '';
                                            echo "<option value='" . $examTypeRow['exam_type'] . "' $selected>" . $examTypeRow['exam_type'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                        <br>
                                    <label for="username_filter">Filtrar por Usuário:</label>
                                    <input type="text" name="username_filter" id="username_filter" value="<?php echo $usernameFilter; ?>">

                                    <input type="submit" value="Filtrar">
                                </form>
                                <?php

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
                                echo "Data do exame";
                                echo "</th>";
                                echo "<th>";
                                echo "Criação de Formulário";
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

                                    echo "<td>";
                                    echo $row["creationdate"];
                                    echo "</td>";

                                    echo "</tr>";
                                }

                                echo "</table>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<?php
include "footer.php";
?>

