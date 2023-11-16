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

$id = $_GET["id"];
$exam_category = '';
$res = mysqli_query($link, "select * from exam_category where id=$id");
while ($row = mysqli_fetch_array($res)) {
    $exam_category = $row["category"];
}
?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Adicionar questões dentro de <?php echo "<font color='red'>" . $exam_category . "</font>"; ?></h1>
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
                        <div class="col-lg-12">
                            <form name="form1" action="" method="post" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-header"><strong>Adicionar novas questões</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <div class="form-group"><label for="company" class=" form-control-label">Questão</label>
                                            <input type="text" placeholder="Adicionar questão" class="form-control" name="question">
                                        </div>

                                        <div class="form-group"><label for="company" class=" form-control-label">Adicione opção 1</label>
                                            <input type="text" placeholder="Adicionar opção 1" class="form-control" name="opt1">
                                        </div>

                                        <div class="form-group"><label for="company" class=" form-control-label">Adicione opção 2</label>
                                            <input type="text" placeholder="Adicionar opção 2" class="form-control" name="opt2">
                                        </div>

                                        <div class="form-group"><label for="company" class=" form-control-label">Adicione opção 3</label>
                                            <input type="text" placeholder="Adicionar opção 3" class="form-control" name="opt3">
                                        </div>

                                        <div class="form-group"><label for="company" class=" form-control-label">Adicione opção 4</label>
                                            <input type="text" placeholder="Adicionar opção 4" class="form-control" name="opt4">
                                        </div>

                                        <div class="form-group"><label for="company" class=" form-control-label">Adicionar resposta</label>
                                            <input type="text" placeholder="Adicionar resposta" class="form-control" name="answer">
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" name="submit1" value="Adicionar questão" class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <!--/.col-->

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Questions</th>
                                    <th>Opt1</th>
                                    <th>Opt2</th>
                                    <th>Opt3</th>
                                    <th>Opt4</th>
                                    <th>Editar</th>
                                    <th>Deletar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $res = mysqli_query($link, "select * from questions where category='$exam_category' order by question_no asc");
                                while ($row = mysqli_fetch_array($res)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row["question_no"]; ?></td>
                                        <td><?php echo $row["question"]; ?></td>
                                        <td><?php echo $row["opt1"]; ?></td>
                                        <td><?php echo $row["opt2"]; ?></td>
                                        <td><?php echo $row["opt3"]; ?></td>
                                        <td><?php echo $row["opt4"]; ?></td>
                                        <td><a href="edit_option.php?id=<?php echo $row["id"]; ?> &id1=<?php echo $id; ?>">Editar</a></td>
                                        <td><a href="delete_option.php?id=<?php echo $row["id"]; ?> &id1=<?php echo $id; ?>">Deletar</a></td>
                                    <?php
                                }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- .animated -->
</div><!-- .content -->

<?php
if (isset($_POST["submit1"])) {
    $loop = 0;
    $count = 0;
    $res = mysqli_query($link, "select * from questions where category='$exam_category' order by id asc") or die(mysqli_error($link));
    $count = mysqli_num_rows($res);

    if ($count == 0) {
    } else {
        while ($row = mysqli_fetch_array($res)) {
            $loop = $loop + 1;
            mysqli_query($link, "update questions set question_no='$loop' where id='$row[id]'");
        }
    }

    $loop = $loop + 1;
    mysqli_query($link, "insert into questions values(NULL,'$loop','$_POST[question]','$_POST[opt1]','$_POST[opt2]','$_POST[opt3]','$_POST[opt4]','$_POST[answer]','$exam_category')") or die(mysqli_error($link));

?>
    <script type="text/javascript">
        alert("questão adicionada com sucesso!");
        window.location.href = window.location.href;
    </script>
<?php
}
?>

<?php
include "footer.php"
?>