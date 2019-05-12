<?php
session_start();

function userform() {
	echo '<div id = "form">
<form method= "post" >
Username:<br>
<input type="text" name="username">
<br><br>
<input type="radio" name="black" value="black piece"><br>
<input type="radio" name="white" value="white piece"><br>
<input type="submit" name="submit" value="Submit">
<input type="submit" name="Guest" value="Guest">
</form>
</div>';
}


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
	<head>
	Hello, <b><?php echo ''.$_SESSION['username'];?></b>(<b id="number_id"><?php echo'<script>y=localStorage.getItem("x");document.getElementById("number_id").innerHTML = y;console.log(y);</script>'?></b>)
	   <p class="logout">
                <a id="exit" href="penn.php">Exit Chat</a>
            </p>
	     <link rel="stylesheet" href="/css/server2.css">
		  <link rel="stylesheet" href="css/chessboard-0.3.0.min.css">
		<script src="https://webrtc.github.io/adapter/adapter-4.2.2.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
		   <script src="js/chessboard-0.3.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.2/chess.js"></script>
	</head>

<body>
<br><br>
	<div class="chatsection">
	<div id="board1" style="width: 500px"></div>
	<br><br><br><br>
	 <div id='turn'> It's Whites turn!</div>
	 </div>
 	 <script>
	 var cfg = {
		 draggable: true,
		 position: 'start'
	 };
	 
	 var board = ChessBoard('board1', cfg);
	 </script>
		
	</div>
	
	<div id="options-window" class="fg-creamy bg-lightgrey"></div>
	<div class="whitepage">
		<div id="chatform">
			<?php
				if (file_exists ( "serverlog.html" ) && filesize ( "serverlog.html" ) > 0) {
					$handle = fopen ( "serverlog.html", "r" );
					$contents = fread ( $handle, filesize ( "serverlog.html" ) );
					fclose ( $handle );
					echo $contents;
				}
			?>
		</div>
		<!--<div id="photoform">-->
		<form action="upload4.php" method="post" enctype="multipart/form-data" id="myform">
		<!--<div class='preview'>
		     <img src="" id="img" width="100" height="100">
        </div>-->
            
			<?php
				/*if (file_exists ( "serverlog.html" ) && filesize ( "serverlog.html" ) > 0) {
					$handle = fopen ( "serverlog.html", "r" );
					$contents = fread ( $handle, filesize ( "serverlog.html" ) );
					fclose ( $handle );
					echo $contents;
				}*/
			?>
		<div id="buttons">
			<input type="button" style="visibility:solid;" onClick="loadOptionsWindow('custombg/options-window.html')" value="Edit background" class="custombg">
			<input type="file" name="uploadfile" multiple></input> 
			<input type="submit" name="submit" value="submit" id="submit"></input>
			<input type="submit" name="postimage" value="submitimg" id="postimage"></input>
		</div>
		</form>
	</div>
		<div id="imgmessage">
		</div>
		<form name="message" action="">
			<input id="userform" name="userform" type="text" size="63">
			<input id="submitmsg" name="submitmsg" type="button" value="send">
		</form>		
	</div>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	<script type="text/javascript">	
	var input = document.getElementById('postimage');
	var filesToUpload = input.files;
	var xhr = new XMLHttpRequest();
	
	$(document).ready(function (e){
$("#myform").on('postimage',(function(e){
e.preventDefault();
$.ajax({
url: "upload2.php",
type: "POST",
data:  new FormData(this),
contentType: false,
cache: false,
processData:false,
success: function(data){
$("#chatform").html(data);
},
error: function(){} 	        
});
}));
});
	
	/*$(document).ready(function(){

    $("#but_upload").click(function(){

        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: 'upload3.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("#img").attr("src",response); 
                    $(".preview img").show(); // Display image element
                }else{
                    alert('file not uploaded');
                }
            },
        });
    });
});
	
	
	if (!file.type.match('image.*')) {
  window.alert("unsupported file type")
};*/

 /*var fd = new FormData();
    fd.append("file", file);

    xhr.open("POST", "http://localhost/upload2.php");
    xhr.onloadend = function(e) {
        xhr.responseText;
        if(callback) {
        callback();
    }
}*/
		$(document).ready(function(){
		});
		$("#submitmsg").click(function(){
				var clientmsg = $("#userform").val();
				$.post("postserver.php", {text: clientmsg});
				$("#userform").attr("value", "");
				loadLog;
			return false;
		})
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
		
		/*function loadPhoto () {
			$.ajax({
				url: "serverlog.html",
				cache: false,
				success: function(html){
					$("#photoform").html(html); //Insert chat log into the #chatbox div
					//Auto-scroll
					var newscrollHeight = $("#photoform").attr("scrollHeight") - 20; //Scroll height after the request
					if(newscrollHeight > oldscrollHeight){
						$("#photoform").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
					}
				},
			});
		}*/

	
	</script>
	<script type="text/javascript" src="custombg/js/custombg-loader.js"></script>
</body>
</html>