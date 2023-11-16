<?php
session_start();
include "connection.php";
$date = date("Y-m-d H:i:s");
$_SESSION["end_time"] = date("Y-m-d H:i:s", strtotime($date . "+$_SESSION[exam_time] minutes"));
include "header.php"
?>

<div class="row" style="margin: 0px; padding:0px; margin-bottom: 50px;background: linear-gradient(to right, #3498db, #9b59b6, #e74c3c);">

    <div class="col-lg-6 col-lg-push-3" style="min-height: 500px; background: linear-gradient(to right, #3498db, #9b59b6, #e74c3c);">
        <?php
        $correct = 0;
        $wrong = 0;

        if (isset($_SESSION["answer"])) {
            for ($i = 1; $i <= sizeof($_SESSION["answer"]); $i++) {
                $answer = "";
                $res = mysqli_query($link, "select * from questions where category='$_SESSION[exam_category]' && question_no=$i");
                while ($row = mysqli_fetch_array($res)) {
                    $answer = $row["answer"];
                }
                if (isset($_SESSION["answer"][$i])) {
                    if ($answer == $_SESSION["answer"][$i]) {
                        $correct = $correct + 1;
                    } else {
                        $wrong = $wrong + 1;
                    }
                } else {
                    $wrong = $wrong + 1;
                }
            }
        }

        $count = 0;
        $res = mysqli_query($link, "select * from questions where category='$_SESSION[exam_category]'");
        $count = mysqli_num_rows($res);
        $wrong = $count - $correct;
        echo "<br>";
        echo "<br>";
        echo "<center>";
        echo "Questões totais=" . $count;
        echo "<br>";
        echo "Respostas corretas=" . $correct;
        echo "<br>";
        echo "Respostas erradas=" . $wrong;

        // Calcular a porcentagem de acertos
        $percentage = ($correct / $count) * 100;

        // Definir os gifs com base na porcentagem
        $gif = '';
        if ($percentage >= 75) {
            $gif = 'https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExaW13azl5Yzg4b2hxY21tN29wZWFhdWZnb3gxMzZ5MXhudnR3bGZ5ZyZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/3o72FhxujRMcOqUm8o/giphy.gif';
        } elseif ($percentage >= 50) {
            $gif = 'https://media.giphy.com/media/rgEHeg0e8eYLKphpNg/giphy.gif';
        } elseif ($percentage >= 25) {
            $gif = 'https://media.giphy.com/media/6CBiTQgkaaUfy5t5yJ/giphy.gif';
        } else {
            $gif = 'https://media.giphy.com/media/R4B99GWm99hn3tFlz0/giphy.gif';
        }

        echo "<br>";
        echo "<img src='$gif' alt='GIF'>";
        echo "</center>";
        ?>
    </div>

</div>

<?php
if (isset($_SESSION["exam_start"])) {
    $date = date("Y-m-d");

    mysqli_query($link, "insert into exam_results(id,username,exam_type,total_question,correct_answer,wrong_answer,exam_time)values(NULL,'$_SESSION[username]','$_SESSION[exam_category]','$count','$correct','$wrong','$date')") or die(mysqli_error($link));
}

if (isset($_SESSION["exam_start"])) {
    unset($_SESSION["exam_start"]);
?>
    <script type="text/javascript">
        window.location.href = window.location.href;
    </script>
<?php
}
?>

<?php
include "footer.php";
?>
