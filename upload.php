<?php


// detect IE
function ae_detect_ie() {
    if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}
?><html>
<head>
<title>Jigsaw Puzzle Creator</title>
<script type="text/javascript" src="lib/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="lib/progressbar.js"></script>
<script type="text/javascript" src="lib/enhance.js"></script>
<link rel="stylesheet" type="text/css" href="lib/main.css" />

<script type='text/javascript'>

// Run capabilities test
enhance({
	loadScripts: [
		'lib/jquery-1.7.2.min.js',
		'lib/fileinput.js',
		'lib/example.js'
	],
	loadStyles: ['lib/enhanced.css']
});   

$(document).ready(function(){

	// If image is in the process of being uploaded
	$('#image_upload_form').submit(function(){
		$("#udisplay").html("<img src='img/loading.gif' />");
	});
	
	// If image has completed uploading
	$('iframe[name=upload_to]').load(function(){
	
	
		var result = $(this).contents().text();
	
		if(result !=''){
			
			// Error handling
			if (result == 'Err:big'){
				$('div#ajax_upload_demo img').attr('src','img/s.png');
				$("#udisplay").html("<b>Error:</b> The image file is too large!<br />It must be 300kb or less.<br /><br />");
				return;
			}
			if (result == 'Err:format'){
				$('div#ajax_upload_demo img').attr('src','img/s.png');
				$("#udisplay").html("<b>Error:</b> Invalid format.<br />Only standard image files are acceptable.<br /><br />");
				return;
			}
			
			// If there are no errors
			if (result != 'Err:big' && result != 'Err:format'){
			
				if ($("#timerv").prop("checked")) {
				
					var timerval = "on";
				}
				else {
					var timerval = "off";
				}
				if ($("#guidev").prop("checked")) {
				
					var guideval = "on";
				}
				else {
					var guideval = "off";
				}
			
				window.location.href="index.php?difficulty=" + $('#difficulty').val() + "&timer=" + timerval + "&guide=" + guideval + "&image=" + $(this).contents().text();
		
				
				

			}
	
		}
	});
});
</script>
</head>
<body>


<?php
// If browser is IE, display error message.
if (ae_detect_ie()) {
?>
<br /><br /><center>
<b>Sorry!</b> the image uploader does not work with your current browser, Internet Explorer.<br />Try viewing this website with <a href="http://www.google.com/intl/en/chrome/" style="color:black">Google Chrome</a> instead.</center>

<?php
}
// If browser is not IE, display content
else {
?>

<div id="title">
<a href="index.php">Puzzle Creator</a>
</div>


<center>


</div><br /><br />

<div id='uploader'><div id='ajax_upload_demo'>



<center><form id='image_upload_form' method='post' enctype='multipart/form-data' action='puzzles/upload.php' target='upload_to'>

<div id="uploadbtn">

<div id="options">
Difficulty:&nbsp;<select id="difficulty">
<option value="1">Easy</option>
<option value="2" selected="selected">Normal</option>
<option value="3">Hard</option>
<option value="4">Very Hard</option>
<option value="5">Madness</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Timer:&nbsp;<input type="checkbox" checked="checked" id="timerv" value="on" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Guide:&nbsp;<input type="checkbox" id="guidev" value="off" />
</div><br />

<input type='file' id='file' name='image'/>
<div style="text-align:center">
<input type="submit" name="upload" id="upload" value="Create puzzle!" />
</div>
</div>

</form></center>


<div id="udisplay"></div>


<iframe name='upload_to'>
</iframe>


</div></div>



</center>





<?php
} // End detect IE
?>





</body>
</html>