<?php
session_start();
include "header.php";
include "../connection.php";

if (!isset($_SESSION["admin"])) {
?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
<?php
}

function formatarData($data)
{
    // Não utilize strtotime se a data já está no formato Y-m-d
    return date('Y-m-d', strtotime($data));
}

$filterUser = isset($_POST['filterUser']) ? $_POST['filterUser'] : '';
$filterExamType = isset($_POST['filterExamType']) ? $_POST['filterExamType'] : '';
$filterTotalQuestions = isset($_POST['filterTotalQuestions']) ? $_POST['filterTotalQuestions'] : '';
$filterCorrectAnswers = isset($_POST['filterCorrectAnswers']) ? $_POST['filterCorrectAnswers'] : '';
$filterWrongAnswers = isset($_POST['filterWrongAnswers']) ? $_POST['filterWrongAnswers'] : '';
$filterExamTime = isset($_POST['filterExamTime']) ? $_POST['filterExamTime'] : '';
$filterCreationDate = isset($_POST['filterCreationDate']) ? $_POST['filterCreationDate'] : '';

?>

<div class="breadcrumbs">
    <div class="col-sm-12">
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

                            <!-- Formulário de Filtro -->
                            <form method="post" action="">
                                <label for="filterUser">Filtrar por Usuário:</label>
                                <input type="text" name="filterUser" id="filterUser" value="<?php echo $filterUser; ?>">
                                
                                <label for="filterExamType">Filtrar por Tipo de Exame:</label>
                                <input type="text" name="filterExamType" id="filterExamType" value="<?php echo $filterExamType; ?>">
                                
                                <label for="filterTotalQuestions">Filtrar por Questões Totais:</label>
                                <input type="text" name="filterTotalQuestions" id="filterTotalQuestions" value="<?php echo $filterTotalQuestions; ?>">
                                
                                <label for="filterCorrectAnswers">Filtrar por Respostas Corretas:</label>
                                <input type="text" name="filterCorrectAnswers" id="filterCorrectAnswers" value="<?php echo $filterCorrectAnswers; ?>">
                                
                                <label for="filterWrongAnswers">Filtrar por Respostas Erradas:</label>
                                <input type="text" name="filterWrongAnswers" id="filterWrongAnswers" value="<?php echo $filterWrongAnswers; ?>">
                                
                                <label for="filterExamTime">Filtrar por Data Realizada:</label>
                                <input type="text" name="filterExamTime" id="filterExamTime" value="<?php echo $filterExamTime; ?>">
                                
                                <label for="filterCreationDate">Filtrar por Criação Formulário:</label>
                                <input type="text" name="filterCreationDate" id="filterCreationDate" value="<?php echo $filterCreationDate; ?>">
                                
                                <button type="submit">Filtrar</button>
                            </form>

                            <?php
                            $count = 0;
                            
                            // Adicionando condições de filtro
                            $filterConditions = array();
                            if (!empty($filterUser)) $filterConditions[] = "exam_results.username LIKE '%$filterUser%'";
                            if (!empty($filterExamType)) $filterConditions[] = "exam_results.exam_type LIKE '%$filterExamType%'";
                            if (!empty($filterTotalQuestions)) $filterConditions[] = "exam_results.total_question LIKE '%$filterTotalQuestions%'";
                            if (!empty($filterCorrectAnswers)) $filterConditions[] = "exam_results.correct_answer LIKE '%$filterCorrectAnswers%'";
                            if (!empty($filterWrongAnswers)) $filterConditions[] = "exam_results.wrong_answer LIKE '%$filterWrongAnswers%'";
                            if (!empty($filterExamTime)) $filterConditions[] = "exam_results.exam_time LIKE '%$filterExamTime%'";
                            if (!empty($filterCreationDate)) $filterConditions[] = "exam_category.creationdate LIKE '%$filterCreationDate%'";

                            $filterCondition = !empty($filterConditions) ? " AND " . implode(" AND ", $filterConditions) : "";

                            $res = mysqli_query($link, "SELECT exam_results.*, exam_category.creationdate 
                                                         FROM exam_results 
                                                         LEFT JOIN exam_category ON exam_results.exam_type = exam_category.category 
                                                         WHERE 1 $filterCondition
                                                         ORDER BY exam_results.id DESC");
                            $count = mysqli_num_rows($res);

                            if ($count == 0) {
                            ?>
                                <center>
                                    <h1>Nenhum resultado encontrado</h1>
                                </center>
                            <?php
                            } else {
                            ?>
                                <div class="table-responsive">
                                    <table class='table table-bordered'>
                                        <thead style='background-color: #006df0; color:white'>
                                            <tr>
                                                <th>Usuário</th>
                                                <th>Tipo de Exame</th>
                                                <th>Questões Totais</th>
                                                <th>Respostas Corretas</th>
                                                <th>Respostas Erradas</th>
                                                <th>Data Realizada</th>
                                                <th>Criação Formulário</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_array($res)) {
                                                echo "<tr>";
                                                echo "<td>" . $row["username"] . "</td>";
                                                echo "<td>" . $row["exam_type"] . "</td>";
                                                echo "<td>" . $row["total_question"] . "</td>";
                                                echo "<td>" . $row["correct_answer"] . "</td>";
                                                echo "<td>" . $row["wrong_answer"] . "</td>";
                                                echo "<td>" . $row["exam_time"] . "</td>";
                                                echo "<td>" . $row["creationdate"] . "</td>"; // Nova coluna para Criação Formulário
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<?php
include "footer.php";
?>

