<?php
require 'vendor/autoload.php';
require_once "Options.php";
$loader = new Twig_Loader_Filesystem(".");
$twig = new Twig_Environment($loader, array(
    //"cache" => "cache/"
));

echo $twig->render('makeme.html', array("options" => Options::get_file_list()));
?>