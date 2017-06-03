<?php

// This file submits high scores to scorelist.php

// If the server is the referer
$formsource = parse_url($_SERVER['HTTP_REFERER']);
if ($_SERVER["SERVER_NAME"] == $formsource[host]) {

	$getdifficulty = $_GET['difficulty'];

	$score = array();
	// Get info, strip html from name
	require('scorelist.php');
	
	$score[$getdifficulty][5]['name'] = strip_tags($_GET['name']);
	$score[$getdifficulty][5]['time'] = $_GET['score'];
	
	
	// Re-sort scores
	$merger[0] = $score[$getdifficulty][0]['time']."<br>".$score[$getdifficulty][0]['name'];
	$merger[1] = $score[$getdifficulty][1]['time']."<br>".$score[$getdifficulty][1]['name'];
	$merger[2] = $score[$getdifficulty][2]['time']."<br>".$score[$getdifficulty][2]['name'];
	$merger[3] = $score[$getdifficulty][3]['time']."<br>".$score[$getdifficulty][3]['name'];
	$merger[4] = $score[$getdifficulty][4]['time']."<br>".$score[$getdifficulty][4]['name'];
	$merger[5] = $score[$getdifficulty][5]['time']."<br>".$score[$getdifficulty][5]['name'];
	

	sort($merger);
	
	$unmerge = explode("<br>", $merger[0]);
	$score[$getdifficulty][0]['time'] = $unmerge[0];
	$score[$getdifficulty][0]['name'] = $unmerge[1];
	
	$unmerge = explode("<br>", $merger[1]);
	$score[$getdifficulty][1]['time'] = $unmerge[0];
	$score[$getdifficulty][1]['name'] = $unmerge[1];
	
	$unmerge = explode("<br>", $merger[2]);
	$score[$getdifficulty][2]['time'] = $unmerge[0];
	$score[$getdifficulty][2]['name'] = $unmerge[1];
	
	$unmerge = explode("<br>", $merger[3]);
	$score[$getdifficulty][3]['time'] = $unmerge[0];
	$score[$getdifficulty][3]['name'] = $unmerge[1];
	
	$unmerge = explode("<br>", $merger[4]);
	$score[$getdifficulty][4]['time'] = $unmerge[0];
	$score[$getdifficulty][4]['name'] = $unmerge[1];


	// Set permissions
	chmod("scorelist.php", 0644);
	
	// Refill scorelist.php
	$file = "scorelist.php"; 
	$handle = fopen($file, 'w');
	$data = "<?php

// Easy
\$score[1][0]['name'] = \"".$score[1][0]['name']."\";
\$score[1][0]['time'] = \"".$score[1][0]['time']."\";
\$score[1][1]['name'] = \"".$score[1][1]['name']."\";
\$score[1][1]['time'] = \"".$score[1][1]['time']."\";
\$score[1][2]['name'] = \"".$score[1][2]['name']."\";
\$score[1][2]['time'] = \"".$score[1][2]['time']."\";
\$score[1][3]['name'] = \"".$score[1][3]['name']."\";
\$score[1][3]['time'] = \"".$score[1][3]['time']."\";
\$score[1][4]['name'] = \"".$score[1][4]['name']."\";
\$score[1][4]['time'] = \"".$score[1][4]['time']."\";

// Normal
\$score[2][0]['name'] = \"".$score[2][0]['name']."\";
\$score[2][0]['time'] = \"".$score[2][0]['time']."\";
\$score[2][1]['name'] = \"".$score[2][1]['name']."\";
\$score[2][1]['time'] = \"".$score[2][1]['time']."\";
\$score[2][2]['name'] = \"".$score[2][2]['name']."\";
\$score[2][2]['time'] = \"".$score[2][2]['time']."\";
\$score[2][3]['name'] = \"".$score[2][3]['name']."\";
\$score[2][3]['time'] = \"".$score[2][3]['time']."\";
\$score[2][4]['name'] = \"".$score[2][4]['name']."\";
\$score[2][4]['time'] = \"".$score[2][4]['time']."\";

// Hard
\$score[3][0]['name'] = \"".$score[3][0]['name']."\";
\$score[3][0]['time'] = \"".$score[3][0]['time']."\";
\$score[3][1]['name'] = \"".$score[3][1]['name']."\";
\$score[3][1]['time'] = \"".$score[3][1]['time']."\";
\$score[3][2]['name'] = \"".$score[3][2]['name']."\";
\$score[3][2]['time'] = \"".$score[3][2]['time']."\";
\$score[3][3]['name'] = \"".$score[3][3]['name']."\";
\$score[3][3]['time'] = \"".$score[3][3]['time']."\";
\$score[3][4]['name'] = \"".$score[3][4]['name']."\";
\$score[3][4]['time'] = \"".$score[3][4]['time']."\";

// Very Hard
\$score[4][0]['name'] = \"".$score[4][0]['name']."\";
\$score[4][0]['time'] = \"".$score[4][0]['time']."\";
\$score[4][1]['name'] = \"".$score[4][1]['name']."\";
\$score[4][1]['time'] = \"".$score[4][1]['time']."\";
\$score[4][2]['name'] = \"".$score[4][2]['name']."\";
\$score[4][2]['time'] = \"".$score[4][2]['time']."\";
\$score[4][3]['name'] = \"".$score[4][3]['name']."\";
\$score[4][3]['time'] = \"".$score[4][3]['time']."\";
\$score[4][4]['name'] = \"".$score[4][4]['name']."\";
\$score[4][4]['time'] = \"".$score[4][4]['time']."\";

// Madness
\$score[5][0]['name'] = \"".$score[5][0]['name']."\";
\$score[5][0]['time'] = \"".$score[5][0]['time']."\";
\$score[5][1]['name'] = \"".$score[5][1]['name']."\";
\$score[5][1]['time'] = \"".$score[5][1]['time']."\";
\$score[5][2]['name'] = \"".$score[5][2]['name']."\";
\$score[5][2]['time'] = \"".$score[5][2]['time']."\";
\$score[5][3]['name'] = \"".$score[5][3]['name']."\";
\$score[5][3]['time'] = \"".$score[5][3]['time']."\";
\$score[5][4]['name'] = \"".$score[5][4]['name']."\";
\$score[5][4]['time'] = \"".$score[5][4]['time']."\";

?>";

	fwrite($handle, $data);

	// Redirect to scoreboard
	header( 'Location: scoreboard.php' ) ;
	

}

// If someone is trying to cheat
else {
	echo "Knock it off.";
}

?>