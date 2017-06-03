<?php

// This file deletes all uploaded pictures

$directory = "puzzles";
$inames = array();
$handler = opendir($directory);
while ($file = readdir($handler)) {
	if ($file != "." && $file != "..") {
		$inames[] = $file;
	}
}
closedir($handler);
foreach ($inames as $iname) {
	if ($iname != "upload.php" && $iname != "default.jpg") {
		unlink($directory."/".$iname);
	}
}

?>Images deleted successfully!