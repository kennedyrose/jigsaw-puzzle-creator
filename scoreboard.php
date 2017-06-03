<?php
require('scorelist.php');
?><html>
<head>
<title>Puzzle Creator</title>
<link rel="stylesheet" type="text/css" href="lib/main.css" />
<style>
li {
	color:#333333;
}
a {
	color: SteelBlue;
}
a:hover {
	color: #333333;
}
</style>
</head>
<body>

<div id="title">
<a href="index.php">Puzzle Creator</a>
</div>

<br /><br /><br />
<center>

<h3>Scoreboard</h3>


<table cellpadding="0" cellspacing="30"><tr>

<td>
<b><a href="index.php?difficulty=5">Madness</a>:</b>
<ol>
<?php
foreach ($score[5] as $loopscore) {
	echo "<li>&nbsp;&nbsp;&nbsp;".$loopscore['time']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$loopscore['name']."</li>";
}
?>
</ol>
</td>

<td>
<b><a href="index.php?difficulty=4">Very Hard:</a></b>
<ol>
<?php
foreach ($score[4] as $loopscore) {
	echo "<li>&nbsp;&nbsp;&nbsp;".$loopscore['time']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$loopscore['name']."</li>";
}
?>
</ol>
</td>

<td>
<b><a href="index.php?difficulty=3">Hard:</a></b>
<ol>
<?php
foreach ($score[3] as $loopscore) {
	echo "<li>&nbsp;&nbsp;&nbsp;".$loopscore['time']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$loopscore['name']."</li>";
}
?>
</ol>
</td>

</tr><tr>

<td>
<b><a href="index.php?difficulty=2">Normal:</a></b>
<ol>
<?php
foreach ($score[2] as $loopscore) {
	echo "<li>&nbsp;&nbsp;&nbsp;".$loopscore['time']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$loopscore['name']."</li>";
}
?>
</ol>
</td>

<td>
<b><a href="index.php?difficulty=1">Easy:</a></b>
<ol>
<?php
foreach ($score[1] as $loopscore) {
	echo "<li>&nbsp;&nbsp;&nbsp;".$loopscore['time']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$loopscore['name']."</li>";
}
?>
</ol>
</td>

</tr></table>





</body>
</html>