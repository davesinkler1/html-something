<?php //echo'<script>y=localStorage.getItem("angry")document.getElementById("em_message").innerHTML = y;</script>' ?>

<?php
session_start();
if(isset($_SESSION['username'])){
    $text = $_POST['text'];
    $fp = fopen("serverlog.html", 'a');
      fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['username']."</b>:".($text)."</div>");
    fclose($fp);
}
?>