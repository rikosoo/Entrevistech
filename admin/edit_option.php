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
$id1 = $_GET["id1"];

$question = "";
$opt1 = "";
$opt2 = "";
$opt3 = "";
$opt4 = "";
$answer = "";

$res = mysqli_query($link, "select * from questions where id =$id");
while ($row = mysqli_fetch_array($res)) {
    $question = $row["question"];
    $opt1 = $row["opt1"];
    $opt2 = $row["opt2"];
    $opt3 = $row["opt3"];
    $opt4 = $row["opt4"];
    $answer = $row["answer"];
}
?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Atualizar questão</h1>
            </div>
        </div>
    </div>

</div>

<div class="content mt-3">
    <div class="animated fadeIn">


        <div class="row">
            <div class="col-lg-6">
                <div class="card">

                    <div class="card-body">
                        <div class="col-lg-12">
                            <form name="form1" action="" method="post" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="card-header"><strong>Atualizar questão</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <div class="form-group"><label for="company" class=" form-control-label">Atualize a questão</label>
                                            <input type="text" placeholder="Atualizar questão" class="form-control" name="question" value="<?php echo $question; ?>">
                                        </div>

                                        <div class="form-group"><label for="company" class=" form-control-label">Atualize a opção 1</label>
                                            <input type="text" placeholder="Atualizar opção 1" class="form-control" name="opt1" value="<?php echo $opt1; ?>">
                                        </div>

                                        <div class="form-group"><label for="company" class=" form-control-label">Atualize a opção 2</label>
                                            <input type="text" placeholder="Atualizar opção 2" class="form-control" name="opt2" value="<?php echo $opt2; ?>">
                                        </div>

                                        <div class="form-group"><label for="company" class=" form-control-label">Atualize a opção 3</label>
                                            <input type="text" placeholder="Atualizar opção 3" class="form-control" name="opt3" value="<?php echo $opt3; ?>">
                                        </div>

                                        <div class="form-group"><label for="company" class=" form-control-label">Atualize a opção 4</label>
                                            <input type="text" placeholder="Atualizar opção 4" class="form-control" name="opt4" value="<?php echo $opt4; ?>">
                                        </div>

                                        <div class="form-group"><label for="company" class=" form-control-label">Atualize a resposta</label>
                                            <input type="text" placeholder="Atualizar resposta" class="form-control" name="answer" value="<?php echo $answer; ?>">
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" name="submit1" value="Atualizar questão" class="btn btn-success">
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
    </div><!-- .animated -->
</div><!-- .content -->

<?php
if (isset($_POST["submit1"])) {
    mysqli_query($link, "update questions set question='$_POST[question]',opt1='$_POST[opt1]',opt2='$_POST[opt2]',opt3='$_POST[opt3]',opt4='$_POST[opt4]',answer='$_POST[answer]' where id=$id");

?>
    <script type="text/javascript">
        window.location = "add_edit_questions.php?id=<?php echo $id1; ?>";
    </script>
<?php

}

?>

<?php
include "footer.php"
?>