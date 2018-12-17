<?php
session_start();
function userform() {
	echo '<div id = "form">
<form method= "post" >
Username:<br>
<input type="text" name="username">
<br><br>
<input type="submit" name="submit" value="Submit">
<input type="submit" name="Guest" value="Guest">
</form>
</div>';
}

if (isset($_POST['submit'])){
	if (isset($_POST['username'])){
		$_SESSION['username'] = stripslashes(htmlspecialchars($_POST['username']));
		  $fp = fopen ( "log.html", 'a' );
        fwrite ( $fp, "<div class='msgln'><i>User " . $_SESSION ['username'] . " has joined the chat session.</i><br></div>" );
        fclose ( $fp );
	} else {
		$_SESSION['username'] = 'Guest';
	  $fp = fopen ( "log.html", 'a' );
        fwrite ( $fp, "<div class='msgln'><i>User Guest has joined the chat session.</i><br></div>" );
        fclose ( $fp );
	}
		
}
if (isset ( $_GET ['logout'] )) {
   
    $fp = fopen ( "log.html", "a" );
    fwrite ( $fp, "<div class='msgln'><i>User " . $_SESSION ['username'] . " has left the chat session.</i><br></div>" );
	  fwrite ( $fp, "<div class='msgln'><i>User Guest has left the chat session.</i><br></div>" );
    fclose ( $fp );
    session_destroy ();
    header ( "Location: index.php" );
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="chatted.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<h1 class="title">Chatroom</h1>
</head>
<body>
    <?php
    if (! isset ( $_SESSION ['username'] )) {
        userform ();
    } else {
        ?>
<div id="wrapper">
        <div id="menu">
            <p class="welcome">
                Welcome, <b><?php echo $_SESSION['username']; ?></b>
            </p>
            <p class="logout">
                <a id="exit" href="#">Exit Chat</a>
            </p>
            <div style="clear: both"></div>
        </div>
        <div id="chatbox"><?php
        if (file_exists ( "log.html" ) && filesize ( "log.html" ) > 0) {
            $handle = fopen ( "log.html", "r" );
            $contents = fread ( $handle, filesize ( "log.html" ) );
            fclose ( $handle );
            echo $contents;
        }
        ?></div>

        <form name="message" action="">
            <input name="usermsg" type="text" id="usermsg" size="63" /> <input
                name="submitmsg" type="submit" id="submitmsg" value="Send" />
        </form>
    </div>
    <script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
// jQuery Document
$(document).ready(function(){
});
//jQuery Document
$(document).ready(function(){
    //If user wants to end session
    $("#exit").click(function(){
        var exit = confirm("Are you sure you want to end the session?");
        if(exit==true){window.location = 'index.php?logout=true';}
    });
});
//If user submits the form
$("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("post.php", {text: clientmsg});
        $("#usermsg").attr("value", "");
        loadLog;
    return false;
});
function loadLog(){
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
    $.ajax({
        url: "log.html",
        cache: false,
        success: function(html){
            $("#chatbox").html(html); //Insert chat log into the #chatbox div
            //Auto-scroll
            var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
            if(newscrollHeight > oldscrollHeight){
                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
            }
        },
    });
}
setInterval (loadLog, 1000);
</script>
<?php
    }
    ?>
    <script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">