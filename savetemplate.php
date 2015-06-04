<?php
require_once "Options.php";
$op = new Options();
$op->load_from_post();
try {
	$op->save_as();
	echo "OK";
} catch (Exception $e) {
	echo "NOPE!";
}
?>