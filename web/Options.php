<?php
define("DEFAULT_LOGO", "https://dry-journey-4380.herokuapp.com/logo.jpg");
/**
 * Options short summary.
 *
 * Options description.
 *
 * @version 1.0
 * @author Federiker
 */
class Options
{
    public $titolone = "Falsi d'autore";
	
	public $sottotitolo = "Dipinti ad olio - Realizzati interamente a mano";
	
	public $sottotitolo2 = "Oil Paintings";
    
    public $di = "di";
    
    public $dimensioni = "Dimensioni";
	
	public function __construct() {
        if (isset($_GET["fname"]) && strlen(trim($_GET["fname"])) > 0) {
            $this->fname = trim($_GET["fname"]);
            //Options::get_filename($src);
            //$this->fname = $src;
        }
    }
    
    
	
	public $logo = "https://dry-journey-4380.herokuapp.com/logo.jpg";
	
    public $fname = "default";
	
	//right
	public $autore = "Autore";
	
	public $titolo = "Titolo";
	
	public $year_text = "Anno di esecuzione dell'opera originale";
	
	public $code_text = "Codice Dipinto";
	
	public $telaio = "Telaio";
	
	public $telaio_text = "";
	
	public $garanzia = "Garanzia";
	
	public $garanzia_text = "La foto rappresenta il singolo dipinto in vendita (v. Codice Dipinto, a destra della foto) e non un prodotto simile o, addirittura, l'originale.\nSolo cos&igrave; riteniamo sia possibile acquistare con serenit&agrave; e riscontrare successivamente l'ottima fattura del singolo pezzo.";
    
    public $spedizioni = "Spedizioni";
    
    public $spedizioni_text = "CONSEGNA [b]24-48 ore[/b]\n[b]12,00 &euro;[/b] - PAGAMENTO ANTICIPATO\n[b]18,00 &euro;[/b] - CONTRASSEGNO\nPer ogni dipinto successivo al primo: + 4,00 &euro;\n\nL'imballaggio &egrave; compreso nel costo della spedizione.";
	
    public $pagamenti = "Pagamenti";
    
    public $pagamenti_text = "";
    
    public $contatti = "Contatti";
    
    public $rimborso = "Rimborsi";
    
    public $rimborso_text = "Entro 10 giorni dall'acquisto, qualora non foste soddisfatti, potrete rinviarci il dipinto e l'importo pagato vi verr&agrave; rimborsato al netto delle spese di spedizione.";
    
    public $contatti_text = "Per qualsiasi chiarimento o informazione aggiuntiva non esitate a contattarci.";
    
	public /*void*/ function load_from_file($src = null) {
        try {
            Options::get_filename($src);
            if (file_exists($src)) {
                $json = json_decode(file_get_contents($src), true);
                $this->from_dictionary($json);
            }
            
        }
        catch (Exception $e) {
            //var_dump($e);
        }
	}
	
	public /*void*/ function save_default() {
		$this->save_as("public/default.json");
	}
	
	public /*void*/ function save_as($src = null) {
        Options::get_filename($src);
        $arr = $this->to_dictionary();
		$res = json_encode($arr);
        
		$fhandle = fopen($src, "w");
		fwrite($fhandle, $res);
		fclose($fhandle);
	}
    
    public /*void*/ function load_from_post() {
        $res = array(
            "autore" => !isset($_POST["autore"]) ? "" : fixstr($_POST["autore"]),
            "contatti" => !isset($_POST["contatti"]) ? "" : fixstr($_POST["contatti"]),
            "code_text" => !isset($_POST["code_text"]) ? "" : fixstr($_POST["code_text"]),
            "contatti_text" => !isset($_POST["contatti_text"]) ? "" : fixstr($_POST["contatti_text"]),
            "garanzia" => !isset($_POST["garanzia"]) ? "" : fixstr($_POST["garanzia"]),
            "garanzia_text" => !isset($_POST["garanzia_text"]) ? "" : fixstr($_POST["garanzia_text"]),
            "logo" => !isset($_POST["logo"]) ? DEFAULT_LOGO : fixstr($_POST["logo"]),
            "pagamenti" => !isset($_POST["pagamenti"]) ? "" : fixstr($_POST["pagamenti"]),
            "pagamenti_text" => !isset($_POST["pagamenti_text"]) ? "" : fixstr($_POST["pagamenti_text"]),
            "rimborso" => !isset($_POST["rimborso"]) ? "" : fixstr($_POST["rimborso"]),
            "rimborso_text" => !isset($_POST["rimborso_text"]) ? "" : fixstr($_POST["rimborso_text"]),
            "sottotitolo" => !isset($_POST["sottotitolo"]) ? "" : fixstr($_POST["sottotitolo"]),
            "sottotitolo2" => !isset($_POST["sottotitolo2"]) ? "" : fixstr($_POST["sottotitolo2"]),
            "spedizioni" => !isset($_POST["spedizioni"]) ? "" : fixstr($_POST["spedizioni"]),
            "spedizioni_text" => !isset($_POST["spedizioni_text"]) ? "" : fixstr($_POST["spedizioni_text"]),
            "telaio" => !isset($_POST["telaio"]) ? "" : fixstr($_POST["telaio"]),
            "telaio_text" => !isset($_POST["telaio_text"]) ? "" : fixstr($_POST["telaio_text"]),
            "titolo" => !isset($_POST["titolo"]) ? "" : fixstr($_POST["titolo"]),
            "titolone" => !isset($_POST["titolone"]) ? "" : fixstr($_POST["titolone"]),
            "year_text" => !isset($_POST["year_text"]) ? "" : fixstr($_POST["year_text"]),
            "di" => !isset($_POST["di"]) ? "" : fixstr($_POST["di"]),
            "dimensioni" => !isset($_POST["dimensioni"]) ? "" : fixstr($_POST["dimensioni"])
        );
        $this->from_dictionary($res);
        unset($res);
    }
    
    public /*void*/ function from_dictionary($arr) {
        //foreach ($arr as $k => $v) {
            //$arr[$k] = fixstrin($v);
        //}
        if ($arr == null) {
            return;
        }
        $this->autore = !array_key_exists("autore", $arr) ? "" : $arr["autore"];
        $this->code_text = !array_key_exists("code_text", $arr) ? "" : $arr["code_text"];
        $this->contatti = !array_key_exists("contatti", $arr) ? "" : $arr["contatti"];
        $this->contatti_text = !array_key_exists("contatti_text", $arr) ? "" : $arr["contatti_text"];
        $this->garanzia = !array_key_exists("garanzia", $arr) ? "" : $arr["garanzia"];
        $this->garanzia_text = !array_key_exists("garanzia_text", $arr) ? "" : $arr["garanzia_text"];
        $this->logo = !array_key_exists("logo", $arr) ? "" : $arr["logo"];
        $this->pagamenti = !array_key_exists("pagamenti", $arr) ? "" : $arr["pagamenti"];
        $this->pagamenti_text = !array_key_exists("pagamenti_text", $arr) ? "" : $arr["pagamenti_text"];
        $this->rimborso = !array_key_exists("rimborso", $arr) ? "" : $arr["rimborso"];
        $this->rimborso_text = !array_key_exists("rimborso_text", $arr) ? "" : $arr["rimborso_text"];
        $this->sottotitolo = !array_key_exists("sottotitolo", $arr) ? "" : $arr["sottotitolo"];
        $this->sottotitolo2 = !array_key_exists("sottotitolo2", $arr) ? "" : $arr["sottotitolo2"];
        $this->spedizioni = !array_key_exists("spedizioni", $arr) ? "" : $arr["spedizioni"];
        $this->spedizioni_text = !array_key_exists("spedizioni_text", $arr) ? "" : $arr["spedizioni_text"];
        $this->telaio = !array_key_exists("telaio", $arr) ? "" : $arr["telaio"];
        $this->telaio_text = !array_key_exists("telaio_text", $arr) ? "" : $arr["telaio_text"];
        $this->titolo = !array_key_exists("titolo", $arr) ? "" : $arr["titolo"];
        $this->titolone = !array_key_exists("titolone", $arr) ? "" : $arr["titolone"];
        $this->year_text = !array_key_exists("year_text", $arr) ? "" : $arr["year_text"];
        $this->dimensioni = !array_key_exists("dimensioni", $arr) ? "" : $arr["dimensioni"];
        $this->di = !array_key_exists("di", $arr) ? "" : $arr["di"];
        if (strlen(trim($this->logo)) == 0) {
            $this->logo = DEFAULT_LOGO;
        }   
    }
    
    public /*Hash<string, string>*/ function to_dictionary() {
        return array(
            "autore" => fixstr($this->autore),
            "contatti" => fixstr($this->contatti),
            "code_text" => fixstr($this->code_text),
            "contatti" => fixstr($this->contatti),
            "contatti_text" => fixstr($this->contatti_text),
            "garanzia" => fixstr($this->garanzia),
            "garanzia_text" => fixstr($this->garanzia_text),
            "logo" => fixstr($this->logo),
            "pagamenti" => fixstr($this->pagamenti),
            "pagamenti_text" => fixstr($this->pagamenti_text),
            "rimborso" => fixstr($this->rimborso),
            "rimborso_text" => fixstr($this->rimborso_text),
            "sottotitolo" => fixstr($this->sottotitolo),
            "sottotitolo2" => fixstr($this->sottotitolo2),
            "spedizioni" => fixstr($this->spedizioni),
            "spedizioni_text" => fixstr($this->spedizioni_text),
            "telaio" => fixstr($this->telaio),
            "telaio_text" => fixstr($this->telaio_text),
            "titolo" => fixstr($this->titolo),
            "titolone" => fixstr($this->titolone),
            "year_text" => fixstr($this->year_text),
            "dimensioni" => fixstr($this->dimensioni),
            "di" => fixstr($this->di)
        );
    }
    
    public static function get_filename(&$src) {
        if ($src == null || strlen($src) == 0) {
            $tmp = isset($_POST["fname"]) && strlen(trim($_POST["fname"])) > 0 ? $_POST["fname"] : null;
            $tmp = $tmp == null && isset($_GET["fname"]) && strlen(trim($_GET["fname"])) > 0 ? $_GET["fname"] : $tmp;
            if ($tmp != null) {
                $tmp = str_replace("public/", "", $tmp);
                $tmp = str_replace(".json", "", $tmp);
                $tmp = preg_replace("/[^a-zA-Z\\s0-9]/", "", trim($tmp));
                
            }
            
            if (strlen($tmp) > 0) {
                $src = "public/{$tmp}.json";
            }
            else {
                $src = "public/default.json";                
            }
		}
        //return $src;
    }
    
    public static function get_file_list() {
        $res = array();
        $files = glob("public/*.json"); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                $res[] = $file;
            }
        }
        return $res;
    }
}

function fixstr($str) {
    return  trim($str);
}

function fixstrin($str) {
    return trim(utf8_decode($str));
}

function cleanup_files($ext) {
    
    $files = glob("public/*.{$ext}"); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file)) {
            //echo "<!--" . $file . "-->";
            unlink($file);
        }
    }
}

function clean_file_title(&$n, $title, $code = "") {
    $code = preg_replace("/[^a-zA-Z\\s0-9]/", "", trim($code));
    $code = str_replace(" ", "_", $code);
    if (strlen(trim($code)) > 0) {
        $n = $code;
        return;
    }
    $title = preg_replace("/[^a-zA-Z\\s0-9]/", "", trim($title));
    $title = str_replace(" ", "_", $title);
    if (strlen(trim($title)) == 0) {
        return;
    }
    $n = $title;
}