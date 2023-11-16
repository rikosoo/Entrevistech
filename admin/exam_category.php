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
    return date('d/m/Y', strtotime($data));
}

?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Adicionar exame</h1>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form name="form1" action="" method="post">
                        <div class="card-body">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Adicionar exame</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <div class="form-group">
                                            <label for="company" class=" form-control-label">Categoria do novo exame</label>
                                            <input type="text" placeholder="" class="form-control" name="examname">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat" class=" form-control-label">Tempo do exame em minutos</label>
                                            <input type="text" placeholder="" class="form-control" name="examtime">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="submit1" value="Adicionar exame" class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Categorias de exame</strong>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nome do exame</th>
                                                    <th scope="col">Tempo do exame</th>
                                                    <th scope="col">Data de Criação</th>
                                                    <th scope="col">Editar</th>
                                                    <th scope="col">Deletar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 0;
                                                $res = mysqli_query($link, "SELECT * FROM exam_category");
                                                while ($row = mysqli_fetch_array($res)) {
                                                    $count = $count + 1;
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?php echo $count; ?></th>
                                                        <td><?php echo $row["category"]; ?></td>
                                                        <td><?php echo $row["exam_time_in_minutes"]; ?></td>
                                                        <td><?php echo formatarData($row["creationdate"]); ?></td>
                                                        <td><a href="edit_exam.php?id=<?php echo $row["id"]; ?>">Editar</a></td>
                                                        <td><a href="delete.php?id=<?php echo $row["id"]; ?>">Deletar</a></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<?php
if (isset($_POST["submit1"])) {
    // Obtenha a data atual no formato Y-m-d
    $currentDate = date('Y-m-d');

    // Insira os dados na tabela exam_category
    mysqli_query($link, "INSERT INTO exam_category (category, exam_time_in_minutes, creationdate) VALUES ('$_POST[examname]','$_POST[examtime]', '$currentDate')") or die(mysqli_error($link));
?>
    <script type="text/javascript">
        alert("Exame adicionado com sucesso");
        window.location.href = "exam_category.php";
    </script>
<?php
}
?>

<?php
include "footer.php";
?>
