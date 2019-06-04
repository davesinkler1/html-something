function loadOptionsWindow(html_file_path,event) {
		
	$("#options-window").load(html_file_path);  
	
	/* var load1 = document.createElement('link');
	load1.rel = 'stylesheet';
	load1.type = 'text/css';
	load1.href = 'ey/css/options-window.css';
	$('head').append(load1);
	 */
	/* setTimeout(function(){
	var load1 = document.createElement('script');
	load1.type = 'text/javascript';
	load1.src ='/js/facescript.js';
	document.getElementById('options-window').appendChild(load1);		
	setTimeout(function(){$("#options-window").css('display','block')},10);
	},10)
	 */
	setTimeout(function(){
	var load1 = document.createElement('script');
	load1.type = 'text/javascript';
	load1.src ='http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js';
	document.getElementById('options-window').appendChild(load1);		
	setTimeout(function(){$("#options-window").css('display','block')},10);
	},10)
	
}