<?php
error_reporting(E_ALL ^ E_NOTICE);

// Get difficulty for size of puzzle pieces
$rows = $cols = max(2, min(10, 2 * (isset($_GET['difficulty']) ? $_GET['difficulty'] : 2)));

for($r = 0; $r < $rows; $r++) {
	for($c = 0; $c < $cols; $c++) {
		$h[$r][$c] = (rand(0, 100) > 50) ? 1 : 0;
		$v[$r][$c] = (rand(0, 100) > 50) ? 1 : 0;
	}
}

// Get puzzle image
if ($_GET['image']) { // ERROR
	$dimg = $_GET['image'];
}
else {
	$dimg = "default.jpg";
}
$img = "puzzles/".$dimg;


// Dimensions of image, pieces, and screen
list($width, $height) = getimagesize($img);

$d = floor(min($width / $cols, $height / $rows) / 5);

$vw = floor($width / $cols);
$vh = floor($height / $rows);

$iw = $vw + 2 * $d;
$ih = $vh + 2 * $d;

$xinc = $vw;
if($xinc % 4 == 0) $xinc /= 4;
elseif($xinc % 3 == 0) $xinc /= 3;
elseif($xinc % 2 == 0) $xinc /= 2;

$yinc = $vh;
if($yinc % 4 == 0) $yinc /= 4;
elseif($yinc % 3 == 0) $yinc /= 3;
elseif($yinc % 2 == 0) $yinc /= 2;

$img = urlencode(basename($img));
unset($files);

?><!DOCTYPE html>
<html>
<head>
<title>Jigsaw Puzzle Creator</title>
<script type="text/javascript" src="lib/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="lib/wz_dragdrop.js"></script>
<script type="text/javascript" src="lib/progressbar.js"></script>
<link rel="stylesheet" type="text/css" href="lib/main.css" />

<style>
body {
	overflow:hidden;
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
}
#guide {
	cursor: auto;
	opacity:0.3;
	position: fixed;
	top: 50%;
	left: 50%;
	margin-top: -<?php echo floor($height / 2) ?>px;
	margin-left: -<?php echo floor($width / 2) ?>px;
	z-index:-1000;
	display:none;
}
#adfoot {
	position:fixed;
	bottom:15px;
	width:100%;
	text-align:center;
}
</style>

<script type="text/javascript">

var loadingscreen = 1;

$(document).ready(function() {
	$("#pb1").progressBar();
	
	
});

function newPuzz() {
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
	window.location.href="index.php?difficulty=" + $('#difficulty').val() + "&timer=" + timerval + "&guide=" + guideval + "&image=<?php echo $dimg ?>";
}

function onewPuzz() {
	if ($("#otimerv").prop("checked")) {
	
		var timerval = "on";
	}
	else {
		var timerval = "off";
	}
	if ($("#oguidev").prop("checked")) {
	
		var guideval = "on";
	}
	else {
		var guideval = "off";
	}
	window.location.href="index.php?difficulty=" + $('#odifficulty').val() + "&timer=" + timerval + "&guide=" + guideval + "&image=<?php echo $dimg ?>";
}

function closeWin() {
	$('#win').fadeOut(1000);
	$('#optionsbtn').fadeIn(1000);
	$('#guide').fadeIn(1000);
	loadingscreen = 0;
}

function openWin() {
	$('#optionsbtn').fadeOut(1000);
	$('#guide').fadeOut(1000);
	$('#win').fadeIn(1000);
	loadingscreen = 1;
}

function openOptions() {
	$('#guide').fadeOut(1000);
	$('#optionsbtn').fadeOut(1000);
	$('#optionsmenu').fadeIn(1000);
	loadingscreen = 1;
}

function closeOptions() {
	$('#guide').fadeIn(1000);
	$('#optionsbtn').fadeIn(1000);
	$('#optionsmenu').fadeOut(1000);
	loadingscreen = 0;
}

function resetPuzz() {
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
	window.location.href="index.php?difficulty=" + $('#difficulty').val() + "&timer=" + timerval + "&guide=" + guideval + "&image=default.jpg";

}
function oresetPuzz() {
	if ($("#otimerv").prop("checked")) {
	
		var timerval = "on";
	}
	else {
		var timerval = "off";
	}
	if ($("#oguidev").prop("checked")) {
	
		var guideval = "on";
	}
	else {
		var guideval = "off";
	}
	window.location.href="index.php?difficulty=" + $('#odifficulty').val() + "&timer=" + timerval + "&guide=" + guideval + "&image=default.jpg";
}


function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
    });
}
preload([
	'img/popover.png',
	'img/loader.gif',
	'img/progressbg_green.gif',
	'img/progressbg_orange.gif',
	'img/progressbg_red.gif',
	'img/progressbg_yellow.gif'
]);

// Timer function
var completed = 0;	
var start = new Date().getTime(), elapsed = '0.0';
var displaysec = 0;
var displaymin = 0;
window.setInterval(function()  {  
	if (loadingscreen == 0) {
		var time = new Date().getTime() - start;  
		elapsed = Math.floor(time / 100) / 10;  
		if(Math.round(elapsed) == elapsed) { elapsed += '.0'; }
		if (completed == 0) {
			displaysec = Math.floor(elapsed);
			displaymin = Math.floor(displaysec / 60)
			while (displaysec >= 60) {
				displaysec = displaysec - 60;
			}
			if (displaysec < 10) {
				displaysec = "0" + displaysec;
			}
			$('#timer').html(displaymin + ":" + displaysec);
			
		}
	}
}, 100);

window.onload = function () {
	// Ditch loading screen
	$('#loader').hide();
	$('#guide').show();
	loadingscreen = 0;	
}

function submitScore() {
	window.location.href="submit.php?difficulty=<?php echo $_GET['difficulty'] ?>&name=" + $('#scorename').val() + "&score=" + displaymin + ":" + displaysec;
}

</script>



</head>
<body>

<div id="title">
<a href="index.php">Puzzle Creator</a>
</div>

<?php
if ($_GET['guide'] == "on") { // ERROR
?>
<div id="guide">
<img src="puzzles/<?php echo $img ?>" />
</div>
<?php
}
?>

<div id="loader">
<center><div id="spinner"><br /><br /><br /><br /><br /><br /><br /><img src="img/loader.gif" style="cursor: auto;" width="128" height="128" /><br /><br /><br /><b>Loading pieces...</b></div></center>
</div>

<div id="win">
<center><div class="blackbox"><br /><br /><br />
<div class="message">
<img src="img/x.png" align="right" onclick="closeWin()" />
<center><br />
<div id="replaceme">
<h3>You completed the puzzle!</h3>

Your total time was <b><span id="totaltime"></span></b><br /><br />

<br />
<div style="width:185px;text-align:left;">
<div style="display:inline;">
Difficulty: <select id="difficulty">
<option value="1"<?php
if ($_GET['difficulty'] == 1)
	echo " selected=\"selected\"";
?>>Easy</option>
<option value="2"<?php
if ($_GET['difficulty'] == 2 || !$_GET['difficulty'])
	echo " selected=\"selected\"";
?>>Normal</option>
<option value="3"<?php
if ($_GET['difficulty'] == 3)
	echo " selected=\"selected\"";
?>>Hard</option>
<option value="4"<?php
if ($_GET['difficulty'] == 4)
	echo " selected=\"selected\"";
?>>Very Hard</option>
<option value="5"<?php
if ($_GET['difficulty'] == 5)
	echo " selected=\"selected\"";
?>>Madness</option>
</select><br />
Timer:&nbsp;<input type="checkbox" id="timerv"<?php
if ($_GET['timer'] != "off") {
	echo " checked=\"checked\"";
}
?> /><br />
Guide:&nbsp;<input type="checkbox" id="guidev"<?php
if ($_GET['guide'] == "on") {
	echo " checked=\"checked\"";
}
?> /><br />
</div>
</div><br />
<button type="button" id="newpuzzle" onclick="newPuzz()">Start new puzzle!</button><br /><br />
<i>or</i><br /><br />
<?php
if (!$_GET['image'] || $_GET['image'] == "default.jpg") {
	echo "<a href=\"upload.php\">Upload an image to use as a puzzle!</a>";
}
else {
	echo "<a href=\"upload.php\">Upload a new image</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick=\"resetPuzz()\" style=\"cursor:pointer\" class=\"fakelink\"><u>Play the default puzzle</u></a>";
}
?><br /><br /><br /><br />
</center>
</div></div>
</div></center>
</div>





<div id="optionsmenu">
<center><div class="blackbox"><br /><br /><br />
<div class="message">
<img src="img/x.png" align="right" onclick="closeOptions()" />
<center><br />
<h3>Options:</h3>
<div style="width:185px;text-align:left;">
<div style="display:inline;">
Difficulty: <select id="odifficulty">
<option value="1"<?php
if ($_GET['difficulty'] == 1)
	echo " selected=\"selected\"";
?>>Easy</option>
<option value="2"<?php
if ($_GET['difficulty'] == 2 || !$_GET['difficulty'])
	echo " selected=\"selected\"";
?>>Normal</option>
<option value="3"<?php
if ($_GET['difficulty'] == 3)
	echo " selected=\"selected\"";
?>>Hard</option>
<option value="4"<?php
if ($_GET['difficulty'] == 4)
	echo " selected=\"selected\"";
?>>Very Hard</option>
<option value="5"<?php
if ($_GET['difficulty'] == 5)
	echo " selected=\"selected\"";
?>>Madness</option>
</select><br />
Timer:&nbsp;<input type="checkbox" id="otimerv"<?php
if ($_GET['timer'] != "off") {
	echo " checked=\"checked\"";
}
?> /><br />
Guide:&nbsp;<input type="checkbox" id="oguidev"<?php
if ($_GET['guide'] == "on") {
	echo " checked=\"checked\"";
}
?> /><br />
</div>
</div><br />
<button type="button" id="pnewpuzzle" onclick="onewPuzz()">Start new puzzle!</button><br /><br />
<i>or</i><br /><br />
<?php
if (!$_GET['image'] || $_GET['image'] == "default.jpg") {
	echo "<a href=\"upload.php\">Upload an image to use as a puzzle!</a>";
}
else {
	echo "<a href=\"upload.php\">Upload a new image</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick=\"oresetPuzz()\" style=\"cursor:pointer\" class=\"fakelink\">Play the default puzzle</a>";
}
?><br /><br />
<span class="smaller"><a href="scoreboard.php">View Scoreboard</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://codecanyon.net/item/jigsaw-puzzle-creator-with-ad-support/2333973" target="_blank">Buy this script</a></span>
</center>
</div>
</div></center>
</div>

<div id="optionsbtn">
<img src="img/c.png" id="check" onclick="openWin()" />&nbsp;&nbsp;<img src="img/options.png" onclick="openOptions()" />
</div>

<br />
<center>
<div id="pbar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="progressBar" id="pb1">0%</span></div>
<?php
if ($_GET['timer'] != "off") { // ERROR
	?><div id="timer">0:00</div><?php
}
?>

</center>

<?php

// Loop to build each piece
$pnum = 0;
for($r = 0; $r < $rows; $r++) {
	for($c = 0; $c < $cols; $c++) {
		$pnum++;
		$g = chr(65+bindec($v[$r][$c] . (1-$v[$r+1][$c]) . $h[$r][$c] . (1-$h[$r][$c+1]))); // ERROR
		$src = "piece.php?img=$img&r=$r&c=$c&cc=$cols&rr=$rows&d=$d&g=$g";
		echo "<img style=\"position:absolute\" name=\"t_{$r}_{$c}\" src=\"$src\" width=\"$iw\" height=\"$ih\" />\n";
		$list[] = "t_{$r}_{$c}";
	}
}
$list = '"' . join('","', $list) . '"';
?>

<script type="text/javascript">
SET_DHTML(<?php echo $list ?>);

var wincounter = 0;
var conarray = new Array();
var startingcluster = new Array();
var cluster = new Array();
var puzzlestarted = 0;
var founda = 0;
var foundb = 0;
var totalscore = 0;


// Get size of browser window
var winW = 630, winH = 460;
if (document.body && document.body.offsetWidth) {
	winW = document.body.offsetWidth;
	winH = document.body.offsetHeight;
}
if (document.compatMode=='CSS1Compat' && document.documentElement && document.documentElement.offsetWidth ) {
	winW = document.documentElement.offsetWidth;
	winH = document.documentElement.offsetHeight;
}
if (window.innerWidth && window.innerHeight) {
	winW = window.innerWidth - 15;
	winH = window.innerHeight - 15;
}



// Get IDs, spread out pieces
var ycoord = 0
for(r = 0; r < <?php echo $rows ?>; r++) {
	for(c = 0; c < <?php echo $cols ?>; c++) {
		id = 't_' + r + '_' + c;
		obj = dd.elements[id];
		ycoord = <?php echo $yinc ?> * Math.round(Math.random() * (winH - <?php echo $ih ?>) / <?php echo $yinc ?>);
		
		// This loop moves pieces out of the way of the menu bar. Replace if a better solution is found.
		while (ycoord <= 50) {
			ycoord = <?php echo $yinc ?> * Math.round(Math.random() * (winH - <?php echo $ih ?>) / <?php echo $yinc ?>);
		}
		obj.moveTo(<?php echo $xinc ?> * Math.round(Math.random() * (winW - <?php echo $iw ?>) / <?php echo $xinc ?>), ycoord);
		obj.row = r;
		obj.col = c;
		obj.cluster = id;
		cluster[id] = new Array();
		cluster[id][id] = id;
		

		
	}
}

var scoremin = 99;
var scoresec = 59;
// Clusters being moved or formed
function merge_cluster(a, b) {
	// Stopper for score counter if function is calleld multiple times in a drop
	var stopper = 0;
	for(i in cluster[b]) {
		obj = dd.elements[cluster[b][i]];
		cluster[a][obj.name] = obj.name;
		obj.cluster = a;

		// If an attachment is being made
		if (a != b) {

			// Cluster counter
			// If this is the first connection, designate this as the starting cluster
			if (puzzlestarted == 0) {
				startingcluster[0] = a + b;
				puzzlestarted = 1;
			}
			
			// If this is not the first connection
			else if (stopper == 0) {
				stopper = 1;
				
				founda = -1;
				foundb = -1;
			
				var rga = new RegExp(a,'g');
				var rgb = new RegExp(b,'g');
				
				// Loop for each cluster, checking for a and b
				var q = 0;
				var until = startingcluster.length - 1;
				while (q <= until) {
					var srchstr = startingcluster[q];
					
					if (srchstr.search(rga) >= 0) {
						founda = q;
					}
					if (srchstr.search(rgb) >= 0) {
						foundb = q;
					}
					
					q = q + 1;
					
				}
				
				
				
				// If a was found and b was not, add b to a's cluster
				if (founda > -1 && foundb < 0) {
					startingcluster[founda] = startingcluster[founda] + b;
				}
				// If b was found and a was not, add a to b's cluster
				if (foundb > -1 && founda < 0) {
					startingcluster[foundb] = startingcluster[foundb] + a;
				}
				
				// If neither were found, then a new cluster is being formed
				if (founda < 0 && foundb < 0) {
					startingcluster.push(a + b);
				}
				// If both were found, then two clusters are being joined
				if (founda > -1 && foundb > -1) {
					startingcluster[founda] = startingcluster[founda] + startingcluster[foundb];
					startingcluster.splice(foundb,1);
				}
	
			
			}
			
			// Number of connections counter
			if (jQuery.inArray(b, conarray) < 0) {
				conarray.push(b);
			}
			if (jQuery.inArray(a, conarray) < 0) {
				conarray.push(a);
			}
			
			// Calculate and display percentage score
			totalscore = (conarray.length / <?php echo $pnum ?>) * 100;
			totalscore = Math.round(totalscore);
			totalscore = totalscore - (startingcluster.length - 1);
			$('#pb1').progressBar(totalscore);
			
			var puzzlecompletestarted = 0;
			
			// If puzzle is completed
			if (totalscore == 100 && !puzzlecompletestarted) {
				puzzlecompletestarted = 1;
			
				// Get final time
				var time = new Date().getTime() - start;  
				elapsed = Math.floor(time / 100) / 10;  
				if(Math.round(elapsed) == elapsed) { elapsed += '.0'; }
				if (completed == 0) {
					displaysec = Math.floor(elapsed);
					displaymin = Math.floor(displaysec / 60);
					scoremin = displaymin;
					while (displaysec >= 60) {
						displaysec = displaysec - 60;
					}
					scoresec = displaysec;
					if (displaysec < 10) {
						displaysec = "0" + displaysec;
					}
					$('#timer').html(displaymin + ":" + displaysec);
					
				}
				completed = 1;
				// Show winning message
				loadingscreen = 1;
				$('#totaltime').html(displaymin + ":" + displaysec);
				$('#guide').fadeOut(1000);
				$('#win').fadeIn(1000);
				$('#check').show(1000);
				$('#optionsbtn').fadeOut(1000);
				
				
				// If high score
				<?php
				require('scorelist.php');
				if (!$_GET['difficulty'])
					$curdiff = 2;
				else
					$curdiff = $_GET['difficulty'];
				$usescore = explode(":", $score[$curdiff][4]['time']);
				?>
				
				var gohighscore = 0;
				
				// If minute is lower
				if (scoremin < <?php echo  intval($usescore[0]) ?>) {
					gohighscore = 1;
				}
				// If minute is same, but second is lower
				if (scoremin == <?php echo  intval($usescore[0]) ?> && scoresec < <?php echo  intval($usescore[1]) ?>) {
					gohighscore = 1;
				}
				
				if (gohighscore == 1) {
					$('#replaceme').html("<h3>YOU GOT A HIGH SCORE!</h3>Your final time was " + scoremin + ":" + displaysec + "<br /><br />Name: <input type=\"text\" id=\"scorename\" /><br /><br /><button type=\"button\" id=\"submitscore\" onclick=\"submitScore()\">Submit score!</button>");
				}
				
				
			}
		}
		
	}
}


// Align piece to invisible grid
function align_cluster(a) {
	for(i in cluster[a]) {
		obj = dd.elements[cluster[a][i]];
		obj.moveTo(<?php echo $xinc ?> * Math.round(obj.x / <?php echo $xinc ?>), <?php echo $yinc ?> * Math.round(obj.y / <?php echo $yinc ?>));
	}
}


// Pick up and move pieces
function my_DragFunc() {
	for(i in cluster[dd.obj.cluster]) {
		obj = dd.elements[cluster[dd.obj.cluster][i]];
		if(obj.name != dd.obj.name) {
			ox = dd.obj.x + (obj.col - dd.obj.col) * <?php echo $vw ?>;
			oy = dd.obj.y + (obj.row - dd.obj.row) * <?php echo $vh ?>;
			obj.moveTo(ox, oy);
		}
	}
	


}

// Let go of pieces
function my_DropFunc() {
	align_cluster(dd.obj.cluster);
	for(r = -1; r <= 1; r++) {
		for(c = -1; c <= 1; c++) {
			if(c != 0 || r != 0) {
			obj = dd.elements['t_'+(dd.obj.row + r)+'_'+(dd.obj.col + c)];
				if(obj) {
					if(dd.obj.x + c * <?php echo $vw ?> == obj.x && dd.obj.y + r * <?php echo $vh ?> == obj.y) {
						merge_cluster(dd.obj.cluster, obj.cluster);
					}
				}
			}
		}
	}
}




</script>

<div id="adfoot"><?php
// Display ad.txt contents
echo file_get_contents("ad.txt");
?></div>

<div id="debug"></div>

</div>

</body></html>