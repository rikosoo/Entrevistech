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
$res = mysqli_query($link, "select * from exam_category where id=$id");
while ($row = mysqli_fetch_array($res)) {
    $exam_category = $row["category"];
    $exam_time = $row["exam_time_in_minutes"];
}
?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Editar exame</h1>
            </div>
        </div>
    </div>

</div>

<div class="content mt-3">
    <div class="animated fadeIn">


        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <form name="form1" action="" method="post">
                        <div class="card-body">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header"><strong>Editar exame</strong>
                                    </div>
                                    <div class="card-body card-block">
                                        <div class="form-group"><label for="company" class=" form-control-label">Editar exame</label>
                                            <input type="text" placeholder="" class="form-control" name="examname" value="<?php echo $exam_category; ?>">
                                        </div>

                                        <div class="form-group"><label for="vat" class=" form-control-label">Tempo do exame em minutos</label>
                                            <input type="text" placeholder="" class="form-control" name="examtime" value="<?php echo $exam_time; ?>">
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" name="submit1" value="Atualizar exame" class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>

            </div>
            <!--/.col-->

        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<?php
if (isset($_POST["submit1"])) {
    mysqli_query($link, "update exam_category set category='$_POST[examname]', exam_time_in_minutes='$_POST[examtime]' where id=$id") or die(mysqli_error($link));

?>
    <script type="text/javascript">
        alert("Exame alterado com sucesso!");
        window.location = "exam_category.php";
    </script>
<?php
}
?>
<?php
include "footer.php"
?>