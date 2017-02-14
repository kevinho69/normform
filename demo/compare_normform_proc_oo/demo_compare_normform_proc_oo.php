<?php
/**
 * demo_normform.php dient zur Erfassung, Verarbeitung und Validierung von Formulardaten.
 *
 * Sie nutzt dazu normform.inc.php, das grundlegende Abläufe festlegt, die bei allen Webseiten, die darauf beruhen,
 * gleich abgehandelt werden.
 *
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @package hm2
 * @version 2017
 */
require_once 'normform.inc.php';

/**
 * Konstanten für ein HTML Attribute <input name='vorname' id='vornamel' ...> --> <input name=EMAIL id=EMAIL ...> usw.
 * Diese Konstanten sind in der OO-TNormform später Klassenkonstanten, die mit const definiert werden
 * Daher sind sie auch in der prozeduralen Normform nicht ausgelagert.
 * Variablen, die in einem eigenen define.inc.php liegen, benötigen wir hier noch nicht,
 * wird es aber bei der OO-TNormform geben.
 */
define("VORNAME", "vorname");
define("NACHNAME", "nachname");
define("NACHRICHT", "nachricht");

/**
 * Zeigt im Fehlerfall vom Nutzer bereits eingegebene Werte wieder an.
 * Die Namen der Input-Felder <input name=EMAIL> usw. werden zugewiesen.
 * Falls von einem vorigen Absenden noch Werte vorhanden sind, werden diese über die Funktion {@see autofill_formfield()} wieder eingefügt,
 */
function prepare_formfields() {
// Als Objekteigenschaften in der OO-TNormform über $this->errmsg usw. von überall ansprechbar. Man benötigt in OO kein global.
    global $errmsg;
    global $script_name;
    global $vorname_key;
    global $nachname_key;
    global $nachricht_key;
    global $vorname_value;
    global $nachname_value;
    global $nachricht_value;
    // Diese Anweisung verschwindet später im Smarty-Template
    $script_name = $_SERVER["SCRIPT_NAME"];
    // Die folgenden Werte werden später mit $smarty->assign() an das Template weitergegeben.
    $vorname_key = VORNAME;
    $nachname_key = NACHNAME;
    $nachricht_key = NACHRICHT;
// Falls das Formular im Gutfall erneut angezeigt werden soll, werden die zuvor eingegebenen Werte nicht mehr angezeigt und das Formular geleert
    if (isset($errmsg) && count($errmsg) !== 0) {
        $vorname_value = autofill_formfield(VORNAME);
        $nachname_value = autofill_formfield(NACHNAME);
        $nachricht_value = autofill_formfield(NACHRICHT);
    }
    else {
        $vorname_value = null;
        $nachname_value = null;
        $nachricht_value = null;
    }
}

/**
 * Erzeugt die HTML-Seite und zeigt sie an (Später werden hier Smarty-Templates eingesetzt)
 */
function display() {
    global $errlines;
    global $statuslines;
    global $script_name;
    global $vorname_key;
    global $nachname_key;
    global $nachricht_key;
    global $vorname_value;
    global $nachname_value;
    global $nachricht_value;
    global $resultlines;

    /**
     *
     * Hier wird HEREDOC-Syntax verwendet, um Strings zu bilden
     *
     * Soll das Formular im Gutfall wieder angezeigt werden?
     * Wenn $statusmsg in process_form nicht befüllt wird, ist ein Fehler aufgetreten und das Formular wird angezeigt.
     * Wenn die Verarbeitung fehlerfrei abgeschlossen werden konnte, wird das Formular nicht mehr angezeigt,
     * sondern nur das Ergebnis, das in $statusmsg gespeichert ist.
     * Falls das Formular auch im Gutfall angezeigt werden soll, diese if-Abfrage auskommentieren (else-Zweig weiter unten nicht vergessen)
     * // durch /* ersetzen vor if- und else- Zeile
     * und in @see process_form(), um die Seite erneut initial aufzurufen, die letzte Zeile der $statusmsg auskommentieren.
     */

//
    //if (strlen($statusmsg) === 0) {
//*/
        /*$form = <<<FORM
<h1>Normformular</h1>
<p>Bitte um Ihre Angaben, mit "*" markierte Felder müssen ausgefüllt werden.</p>
$errlines
<form action="$script_name" method="post">
    <div>
        <label for="$vorname_key"> * Vorname:</label>
        <input type="text" name="$vorname_key" id="$vorname_key" value="$vorname_value">
        <p></p>
    </div>
    <div>
        <label for="$nachname_key"> * Nachname:</label>
        <input type="text" name="$nachname_key" id="$nachname_key" value="$nachname_value"><br>
        <p></p>
    </div>
    <div>
        <label for="$nachricht_key">Nachricht:</label>
        <textarea name="$nachricht_key" id="$nachricht_key" rows="5" cols="60">$nachricht_value</textarea>
    </div>
    <button type="submit">Absenden</button>
</form>
FORM;*/
        $form = <<<FORM
<form action="$script_name" method="post">
    <div class="Grid Grid--gutters">
        <div class="InputCombo Grid-full">
            <label for="$vorname_key" class="InputCombo-label">Vorname:</label>
            <input type="text" id="$vorname_key" name="$vorname_key" value="$vorname_value" class="InputCombo-field">
        </div>
        <div class="InputCombo Grid-full">
            <label for="$nachname_key" class="InputCombo-label">Nachname:</label>
            <input type="text" id="$nachname_key" name="$nachname_key" value="$nachname_value" class="InputCombo-field">
        </div>
        <div class="InputCombo Grid-full">
            <label for="$nachricht_key" class="InputCombo-label">Nachricht:</label>
            <textarea name="$nachricht_key" id="$nachricht_key" class="InputCombo-field">$nachricht_value</textarea>
        </div>
        <div class="Grid-full">
            <button type="submit" class="Button">Send</button>
        </div>
    </div>
</form>
FORM;

        //
    /*}
    else {
        $form = null;
    }*/
    //*/
// Inhalt des templates header.tpl in OO-TNormform
/*    $header = <<<HEADER
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Normformular</title>
    <link rel="stylesheet" href="../css/proceduralstyles.css">
</head>
<body>
HEADER;*/
    $header = <<<HEADER
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo Normform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="Site">
HEADER;


// Inhalt des templates indexMain.tpl in OO-TNormform
    /*$main = <<<MAIN
<main id="container">
    $statusmsg
    $form
</main>*/
    $main = <<<MAIN
   <main class="Site-content">
    <section class="Section">
        <div class="Container">
            <h2 class="Section-heading">Normform Demo</h2>
            $errlines
            $statuslines
            $form
        </div>
    </section>
    <section class="Section">
        <div class="Container">
            <h2 class="Section-heading">Result in \$_POST</h2>
            $resultlines
        </div>
    </section>
</main> 
MAIN;
// Inhalt des templates footer.tpl in OO-TNormform
    /*$footer = <<<FOOTER
</body>
</html>
FOOTER;*/
    $footer = <<<FOOTER
<footer class="Site-footer">
    <div class="Footer Footer--small">
        <p class="Footer-credits">Created and maintained by <a href="mailto:martin.harrer@fh-hagenberg.at">Martin Harrer</a> and <a href="mailto:wolfgang.hochleitner@fh-hagenberg.at">Wolfgang Hochleitner</a>.</p>
        <p class="Footer-version"><i class="fa fa-file-text-o" aria-hidden="true"></i>Normform Demo Version 2017</p>
        <p class="Footer-credits"><i class="fa fa-github" aria-hidden="true"></i><a href="https://github.com/Digital-Media/normform">GitHub</a></p>
    </div>
</footer>
</body>
</html>
FOOTER;

    echo $header;
    echo $main;
    echo $footer;
}

/**
 * Überprüft, ob das Formularfeld korrekt ausgefüllt wurde. Die Kriterien werden in dieser Funktion anhand verschiedener
 * if-Bedingungen selbst angegeben. Schlägt ein Kriterium fehl, wird ein Eintrag in das globale Array <pre>$errMsg</pre>
 * geschrieben.
 * Passende Funktionen/Methoden für spezielle Eingabefelder finden sich in Utilities.class.php
 *
 * @global array $errMsg Beinhaltet mögliche Fehlermeldungen, die bei der Validierung aufgetreten sind und später
 * mit @see print_errmsg() von normform.inc.php ausgegeben werden.
 * @return bool Gibt <pre>true</pre> zurück, wenn alle Kriterien erfüllt wurden, ansonsten <pre>false</pre>.
 */
function is_valid_form(): bool {
    global $errmsg;

    if (is_empty_postfield(VORNAME)) {
        $errmsg[VORNAME] = "Vorname fehlt.";
    }
    if (is_empty_postfield(NACHNAME)) {
        $errmsg[NACHNAME] = "Nachname fehlt.";
    }
    return !isset($errmsg);
}

/**
 * Verabeitet die Dateun und gibt die Ergebnisseite aus.
 * In diesem Grundgerüst wird lediglich der Inhalt der Variable <pre>$_POST</pre> ausgegeben.
 * Hier wird in späteren Übungen sinnvollerer Inhalt stehen.
 */
function process_form() {
    //global $statusmsg;
    global $result;
    global $statusmsg;
    $result = $_POST;

    $statusmsg = "Verarbeitung erfolgreich!";
    //$script_name = $_SERVER["SCRIPT_NAME"];
    /*$statusmsg = '<h1>Normformular Resultat</h1>';
    foreach ($_POST as $k => $v) {
        $statusmsg .= "<b>$k :</b><span>" . nl2br(sanitize_filter($v)) . "</span><br>" . PHP_EOL;
    }*/
// Falls im Gutfall Formular und Ergebnis auf einer Seite angezeigt werden sollen, diese Zeile auskommentieren.
    //$statusmsg .= "<p></p></p><a href='$script_name'>Nochmals</a> " . PHP_EOL;
    /**
     * Falls im Gutfall auf eine weitere Seite weitergeleitet werden soll, geschieht dies an dieser Stelle mit der header()-Anweisung
     * @see show_form() wird dann nicht mehr ausgeführt.
     * /* durch // ersetzen vor der header-Zeile
     */
    /*
     header ("Location: resultpage.html");
     exit;
    //*/
}

function print_result() {
    global $result;
    global $resultlines;
    if (isset($result)) {
        $resultlines = "<table class=\"Table u-tableW100\">" . PHP_EOL;
        $resultlines .= "<colgroup span=\"2\" class=\"u-tableW50\"></colgroup>" . PHP_EOL;
        $resultlines .= "<thead>" . PHP_EOL;
        $resultlines .= "<tr class=\"Table-row\">" . PHP_EOL;
        $resultlines .= "<th class=\"Table-header\">Key</th>" . PHP_EOL;
        $resultlines .= "<th class=\"Table-header\">Value</th>" . PHP_EOL;
        $resultlines .= "</tr>" . PHP_EOL;
        $resultlines .= "</thead>" . PHP_EOL;
        $resultlines .= "<tbody>" . PHP_EOL;
        foreach ($result as $key => $value) {
            $resultlines .= "<tr class=\"Table-row\">" . PHP_EOL;
            $resultlines .= "<td class=\"Table-data\">$key</td>" . PHP_EOL;
            $resultlines .= "<td class=\"Table-data\">" . nl2br(sanitize_filter($value)) . "</td>" . PHP_EOL;
            $resultlines .= "</tr>" . PHP_EOL;
        }
        $resultlines .= "</tbody>" . PHP_EOL;
        $resultlines .= "</table>" . PHP_EOL;
    }
}

/**
 * Hauptaufruf - dies ist der Startpunkt des Normformular-Ablaufs.
 */
normform();
