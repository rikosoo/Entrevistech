<?php
session_start();
if (!isset($_SESSION["username"])) {
?>
    <script type="text/javascript">
        window.location = "login.php";
    </script>
<?php
}
?>

<?php
include "connection.php";
include "header.php"
?>

<div class="row" style="margin: 0px; padding:0px; margin-bottom: 50px; background: linear-gradient(to right, #3498db, #9b59b6, #e74c3c);">

    <div class="col-lg-6 col-lg-push-3" style="min-height: 500px; background: linear-gradient(to right, #3498db, #9b59b6, #e74c3c);">
        <?php
        $res = mysqli_query($link, "SELECT * FROM exam_category ORDER BY id DESC LIMIT 3");
        while ($row = mysqli_fetch_array($res)) {
        ?>
            <input type="button" class="btn btn-success form-control" value="<?php echo $row["category"]; ?>" style="margin-top: 10px; background-color: blue; color: white" onclick="set_exam_type_session(this.value);">
        <?php
        }

        // Verifica se há mais categorias para exibir
        $moreCategoriesQuery = mysqli_query($link, "SELECT * FROM exam_category ORDER BY id DESC LIMIT 999999999 OFFSET 3");
        $moreCategories = mysqli_fetch_assoc($moreCategoriesQuery);

        if ($moreCategories) {
        ?>
            <!-- Container para armazenar categorias adicionais ocultas -->
            <div id="hiddenCategories" style="display: none;">
                <?php
                mysqli_data_seek($moreCategoriesQuery, 0);
                while ($row_all = mysqli_fetch_array($moreCategoriesQuery)) {
                ?>
                    <input type="button" class="btn btn-success form-control" value="<?php echo $row_all["category"]; ?>" style="margin-top: 10px; background-color: blue; color: white" onclick="set_exam_type_session(this.value);">
                <?php
                }
                ?>
            </div>
            <!-- Botão "Mais" para exibir outros existentes -->
            <input type="button" class="btn btn-info form-control" value="Mais" style="margin-top: 10px;" onclick="showAllCategories();">
        <?php
        }
        ?>
    </div>

</div>

<?php
include "footer.php";
?>

<script type="text/javascript">
    function set_exam_type_session(exam_category) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                window.location = "dashboard.php";
            }
        };
        xmlhttp.open("GET", "forajax/set_exam_type_session.php?exam_category=" + exam_category, true);
        xmlhttp.send(null);
    }

    function showAllCategories() {
        var hiddenCategories = document.getElementById('hiddenCategories');

        // Verifica se há categorias ocultas
        if (hiddenCategories.style.display === 'none') {
            // Torna as categorias visíveis
            hiddenCategories.style.display = 'block';
            // Move o botão "Mais" para o final
            hiddenCategories.parentNode.appendChild(hiddenCategories.previousSibling);
        } else {
            // Esconde o botão "Mais" se não houver mais categorias
            document.querySelector('.btn-info').style.display = 'none';
        }
    }
</script>
