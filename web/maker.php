<?php
header("Content-type: text/html; charset=utf-8");
define("CONT_W", 480);
define("BODY_W", 1200);
//@total-width: 1200px;
//define("CONT_W", 600);
define("MAG_CSS_URL", "\"https://dry-journey-4380.herokuapp.com/magnifier.min.css\"");
define("MAG_EMPTY_CSS_URL", "\"https://dry-journey-4380.herokuapp.com/empty.css\"");
//http://www.federicopirani.com/Quadri/paintings/GK60900007.jpg
//http://www.federicopirani.com/Quadri/paintings/guardians.jpg
//http://upload.wikimedia.org/wikipedia/commons/d/d4/Paul_C%C3%A9zanne%2C_1892-95%2C_Les_joueurs_de_carte_%28The_Card_Players%29%2C_60_x_73_cm%2C_oil_on_canvas%2C_Courtauld_Institute_of_Art%2C_London.jpg
require '../vendor/autoload.php';
require_once "Options.php";
$loader = new Twig_Loader_Filesystem(".");
use Intervention\Image;
$title = !isset($_POST["title"]) ? "Titolo" : trim($_POST["title"]);
$year = !isset($_POST["year"]) ? "?" : trim($_POST["year"]);
$url = !(isset($_POST["url"]) && strlen(trim($_POST["url"])) != 0) ? "paintings/rocket.png" : trim($_POST["url"]);
$author = !isset($_POST["author"]) ? "Autore" : trim($_POST["author"]);
$width = !isset($_POST["width"]) ? 10 : filter_var(trim($_POST["width"]), FILTER_SANITIZE_NUMBER_INT);
$height = !isset($_POST["height"]) ? 10 : filter_var(trim($_POST["height"]), FILTER_SANITIZE_NUMBER_INT);
$depth = !isset($_POST["depth"]) ? 2 : filter_var(trim($_POST["depth"]), FILTER_SANITIZE_NUMBER_INT);
$code = !isset($_POST["code"]) ? "" : trim($_POST["code"]);
$ratio = 1;
$norepet = !isset($_POST["repeat"]);
$create = isset($_POST["create"]);
$show3d = isset($_POST["show_3d"]);
$magnify = isset($_POST["magnify"]);

$backgroundAdd = (!isset($_POST["bck_size"]) ? 0 : filter_var(trim($_POST["bck_size"]), FILTER_SANITIZE_NUMBER_INT)) + 100;

$options = new Options();
try {
    $options->load_from_file();
}
catch (Exception $e) {}
//if (!file_exists("public/default.json")) {
//    $options->save_default();
//    //echo "<!--" . json_encode($options->to_dictionary()) . "-->";
    
//}

//$options->load(null);

$bckSize = "100%";
if ($norepet) {
    //$bckSize = "105%";
    $bckSize = $backgroundAdd . "%";
}
$n = time();
clean_file_title($n, $title, $code);
try {
    cleanup_files("jpg");
    cleanup_files("txt");
    cleanup_files("zip");
}
catch (Exception $e) {
}
$zip = new ZipArchive();
$zip->open("public/ebay_{$n}.zip", ZipArchive::CREATE);

$cont_w = CONT_W;
$body_w = BODY_W;
if (!$magnify) {
    $cont_w += 120;
    $body_w -= 100;
}
$thumb = null;

try {
    $img = Intervention\Image\ImageManagerStatic::make($url);
    $w = $img->width();
    $h = $img->height();
    $ratio = $h / $w;
    if ($create) {
        $img->save("public/{$n}.jpg");
        $url = "public/{$n}.jpg";
        $zip->addFile($url, "{$n}.jpg");
        $img->resize($cont_w, $cont_w * $h / $w);
        $img->save("public/{$n}_small.jpg");
        $zip->addFile("public/{$n}_small.jpg", "{$n}_small.jpg");
        $thumb = "'public/{$n}_small.jpg'";
    }
}
catch (Exception $e) {
    //echo "<!--" . var_dump($e) . "-->";
}

$twig = new Twig_Environment($loader, array(
    //"cache" => "cache/"
));
try {
    $parser = new Less_Parser(array("compress" => true));
    $parser->parseFile( 'style.less', '.' );
    $mag = MAG_EMPTY_CSS_URL;
    if ($magnify) {
        $mag = MAG_CSS_URL;
    }
    $parser->ModifyVars(
        array(
            "ratio" => $ratio, 
            "bck-size" => $bckSize, 
            "thumb-width" => $cont_w . "px",
            "total-width" => $body_w . "px",
            "mag-url" => $mag,
            "depth" => (($depth / 2) * 0.5) . "em"
            )
        );
    $css = $parser->getCss();
}
catch (Exception $le) {
    $css = "";
    //echo var_dump($le);
}

$vals = array(
    "title" => $title,
    "year" => $year,
    "author" => $author,
    "width" => $width,
    "height" => $height,
    "depth" => $depth,
    "code" => $code,
    "img_url" => "'" . $url . "'",
    "img_thumb" => $thumb,
    "EventScript" => file_get_contents("Event.min.js"),
    "MagnifierScript" => file_get_contents("Magnifier.min.js"),
    "PaintingScript" => file_get_contents("Paintings.min.js"),
    "MainScript" => file_get_contents("mainscript.min.js"),
    "less" => $css,
    "magcss" => file_get_contents("magnifier.min.css"),
    "options" => $options,
    "show_3d" => $show3d,
    "magnify" => $magnify
    );
$echo = $twig->render('page.html', $vals);
if ($create) {
    $vals["img_url"] = "'http://www.biancaeblu.it/paintings/ebay/{$n}.jpg'";
    if ($thumb != null) {
        $vals["img_thumb"] = "'http://www.biancaeblu.it/paintings/ebay/{$n}_small.jpg'";
    }
}

$ebay = $twig->render('page.html', $vals);
$handle = fopen("public/{$n}.txt", "w");
fwrite($handle, $ebay, strlen($ebay));
fclose($handle);
$zip->addFile("public/{$n}.txt", "{$n}.txt");
$zip->close();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
</head>
    <body lang="it-it">
        <?php
        echo $echo;
        ?>
        <textarea><?php echo $ebay; ?></textarea>
        <a href="public/ebay_<?php echo $n ?>.zip">File zip</a>
    </body>
</html>