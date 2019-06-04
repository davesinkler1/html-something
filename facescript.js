$("#face").click(function(){
        var face = $("#face")
        localStorage.setItem("angry", face)
		var clientmsg = localStorage.getItem("angry")
		$.post("facepost.php", {text: clientmsg});				
		return false;
	});