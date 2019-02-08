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
        fwrite ( $fp, "<div class='msgln'><i>User " . $_SESSION ['username'] . " has joined the session.</i><br></div>" );
        fclose ( $fp );
	 }
	}
?>
<html>
<head>Hello, <?php echo ''.$_SESSION['username'];?> 
 <script src="https://webrtc.github.io/adapter/adapter-4.2.2.js"></script>
</head>
<link rel="stylesheet" href="server2.css"/>
<head>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
</head>
<div class="chatsection">
<label>Your ID:</label><br/>
<textarea id="yourId"></textarea><br/>
<label>Other ID:</label><br/>
<textarea id="otherId"></textarea>
<button id="connect">connect</button><br/>
<form name="notes" action="" method="post" id="notes">
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
<div class="videoContainer">
            <video id="selfVideo"></video>
            <meter id="localVolume" class="volume"></meter>
          </div>
<body>
<div id="options-window" class="fg-creamy bg-lightgrey"></div>
<div class="whitepage">
<form name="message" action="">
<input id="chatform" name="userform" type="text">
<input type="button" style="visibility:solid;" onClick="loadOptionsWindow('custombg/options-window.html')">
<button type="submit" id="mic" value="voice">
</button>
<input type="file" id="uploadfile" name="uploadfile"></input> 
<input type="submit" name="submit" value="submit" id="submit"></input>
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
	echo $imageFileType;
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
<script type="module" src="simplepeer.min.js"></script>
<script type="text/javascript">
navigator.webkitGetUserMedia({
	video: true,
	audio: true
}, function(stream){
  var SimplePeer = require('simple-peer')
  var peer = new SimplePeer({
	initiator: location.hash === '#init',
	trickle: false,
	stream: stream
})	

  peer.on('signal', function(data){
	  document.getElementById('yourId').value = JSON.stringify(data)
})

  document.getElementById('connect').addEventListener('click', function() {
	var otherId = JSON.parse(document.getElementById('otherId').value)
	peer.signal(otherId)
})
  peer.on('stream', function(stream) {
	  var video = document.createElement('video')
	  document.body.appendChild(video)
	  
	  video.src = window.URL.createObjectURL(stream)
	  video.play()
  })
}, function(err) {
	console.error(err)
})
	
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
    var oldscrollHeight = $("#chatform").attr("scrollHeight") - 20; //Scroll height before the request
    $.ajax({
        url: "serverlog.html",
        cache: false,
        success: function(html){
            $("#chatform").html(html); //Insert chat log into the #chatbox div
            //Auto-scroll
            var newscrollHeight = $("#chatform").attr("scrollHeight") - 20; //Scroll height after the request
            if(newscrollHeight > oldscrollHeight){
                $("#chatform").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
            }
        },
    });
}
setInterval (loadLog, 1000);

function d_six() {
	var x = document.getElementById("testbox");
	var min=1;
	var max=6;
	  var random =Math.floor(Math.random() * (+max - +min)) + +min;
	x.innerHTML = random;
}

function d_four() {
	var x = document.getElementById("testbox");
	var min=1;
	var max=4;
	  var random =Math.floor(Math.random() * (+max - +min)) + +min;
	x.innerHTML = random;
}

function d_twenty() {
	console.log("is it executed?")
	var x = document.getElementById("testbox");
	var min=1;
	var max=20;
	  var random =Math.floor(Math.random() * (+max - +min)) + +min;
	x.innerHTML = random;
}

document.getElementById("submitnotes").onclick = function() {
	 var text = document.getElementById("playernotesone").value;
    var li = "<li>" + text + "</li>";
	  
    document.getElementById("list").appendChild(li);
	  }
</script>
<div class="dicebox">
<button OnClick ="d_six()">1d6</button>
<button OnClick ="d_four()">1d4</button>
<button OnClick ="d_twenty()">1d20</button>
<p id="testbox"></p>
</div>
 <script type="text/javascript" src="custombg/js/custombg-loader.js"></script>
</body>
</html>