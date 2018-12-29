<?php
session_start();
if(isset($_SESSION['submit'])){
	
}
 if(isset($_SESSION['username'])) {
 }
 
 if (isset($_SESSION['submit'])){
	if (isset($_SESSION['username'])){
		$_SESSION['username'] = stripslashes(htmlspecialchars($_SESSION['username']));
		  $fp = fopen ( "serverlog.html", 'a' );
        fwrite ( $fp, "<div class='msgln'><i>User " . $_SESSION ['username'] . " has joined the chat session.</i><br></div>" );
        fclose ( $fp );
	 }
	}
?>
<html>
<head>Hello, <?php echo ''.$_SESSION['username'];?> </head>
<link rel="stylesheet" href="server2.css"/>
<head>
</head>
<div class="chatsection">
<form name="notes" action="" method="post">
<input type="text" name="playernotes" id="playernotesone">
</input>
<button type="submit" name="submit" id="submitnotes">Add notes</button>
</form>
<ul id="list">

</ul>
<?php
if (file_exists ( "serverlog.html" ) && filesize ( "serverlog.html" ) > 0) {
            $handle = fopen ( "serverlog.html", "r" );
            $contents = fread ( $handle, filesize ( "serverlog.html" ) );
            fclose ( $handle );
            echo $contents;
}
?>
</div>
<body>
<div class="whitepage">
<form name="message" action="">
<input id="chatform" name="userform" type="text">
<button type="submit" id="mic" value="voice">
</button>
<input type="file" id="uploadfile" name="uploadfile">
</input>
<input type="submit" name="submit" value="submit" id="submit">
</input>
</form>
</div>
<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["uploadfile"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["uploadfile"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["uploadfile"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
<script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
$(document).ready(function(){
});
$("#submit").click(function(){
        var clientmsg = $("#userform").val();
        $.post("postserver.php", {text: clientmsg});
        $("#userform").attr("value", "");
        loadLog;
    return false;
});
function loadLog(){
    var oldscrollHeight = $("#chatsection").attr("scrollHeight") - 20; //Scroll height before the request
    $.ajax({
        url: "serverlog.html",
        cache: false,
        success: function(html){
            $("#chatsection").html(html); //Insert chat log into the #chatbox div
            //Auto-scroll
            var newscrollHeight = $("#chatsection").attr("scrollHeight") - 20; //Scroll height after the request
            if(newscrollHeight > oldscrollHeight){
                $("#chatsection").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
            }
        },
    });
}
setInterval (loadLog, 1000);

function d_six() {
	var x = document.getElementById("testbox");
	var min=1;
	var max=6;
	  var random =Math.floor(Math.random() * (+max - +min))) + +min;
	x.innerHTML = random;
}

document.getElementById("submitnotes").onclick = function() {
	 var text = document.getElementById("playernotesone").value;
    var li = "<li>" + text + "</li>";
	  
    document.getElementById("list").appendChild(li);
	  }
});
</script>
<div class="dicebox">
<button OnClick ="d_six()">1d6</button>
<p id="testbox"></p>
</div>
</body>
</html>