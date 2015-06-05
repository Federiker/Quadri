<?php
require '../vendor/autoload.php';
require_once "Options.php";
$loader = new Twig_Loader_Filesystem(".");
$twig = new Twig_Environment($loader, array(
    //"cache" => "cache/"
));
$options = new Options();
try {
    $options->load_from_file();
} catch (Exception $e) {}

echo $twig->render('text.html', array("options" => $options));
?>