<?php

function LisaOpilane()
{
    $xmlDoc = new DOMDocument("1.0", "UTF-8");
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->load("opilased.xml");
    $xmlDoc->formatOutput = true;

    $xmlRoot = $xmlDoc->documentElement;
    $xmlOpilane = $xmlDoc->createElement("opilane");
    $xmlRoot->appendChild($xmlOpilane);

    $xmlOpilane->appendChild($xmlDoc->createElement("pilt", $_POST["pilt"]));

    $elukoht = $xmlDoc->createElement("elukoht");
    $elukoht->appendChild($xmlDoc->createElement("linn", $_POST["linn"]));
    $elukoht->appendChild($xmlDoc->createElement("maakond", $_POST["maakond"]));
    $xmlOpilane->appendChild($elukoht);

    $xmlOpilane->appendChild($xmlDoc->createElement("nimi", $_POST["nimi"]));
    $xmlOpilane->appendChild($xmlDoc->createElement("eriala", $_POST["eriala"]));
    $xmlOpilane->appendChild($xmlDoc->createElement("isikukood", $_POST["isikukood"]));

    $aine1 = $xmlDoc->createElement("aine");
    $aine1->appendChild($xmlDoc->createElement("nimetus", $_POST["aine1"]));
    $aine1->appendChild($xmlDoc->createElement("hinne", $_POST["hinne1"]));
    $xmlOpilane->appendChild($aine1);

    $aine2 = $xmlDoc->createElement("aine");
    $aine2->appendChild($xmlDoc->createElement("nimetus", $_POST["aine2"]));
    $aine2->appendChild($xmlDoc->createElement("hinne", $_POST["hinne2"]));
    $xmlOpilane->appendChild($aine2);

    $xmlDoc->save("opilased.xml");

    unset($_POST["submit"]);
}
    if(isset($_POST["submit"]))
    {
        LisaOpilane();
        header("Location: " . $_SERVER["PHP_SELF"]);
    }
$opilased=simplexml_load_file("opilased.xml");


//õpilase otsing
function erialaOtsing($paring){
    global $opilased;
    $tulemus=array();
    foreach($opilased->opilane as $opilane) {
        if (substr(strtolower($opilane->eriala), 0, strlen($paring))
            == strtolower($paring)) {
            array_push($tulemus, $opilane);
        } 
        else if (substr(strtolower($opilane->nimi), 0, strlen($paring))
            == strtolower($paring)) {
            array_push($tulemus, $opilane);
        } 
        else if (substr(strtolower($opilane->isikukood), 0, strlen($paring))
            == strtolower($paring)) {
            array_push($tulemus, $opilane);
        }
        else if (substr(strtolower($opilane->aine->nimetus), 0, strlen($paring))
            == strtolower($paring)) {
            array_push($tulemus, $opilane);
        }
        else if (substr(strtolower($opilane->pilt), 0, strlen($paring))
            == strtolower($paring)) {
            array_push($tulemus, $opilane);
        }
    }
    return $tulemus;
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>XML faili kuvamine - Opilased.xml</title>
</head>
<body>
<h1>XML faili kuvamine - Opilased.xml</h1>

<h2>Otsing</h2>

<form action="?" method="post">
    <label for="otsing">Otsi:</label>
    <input type="text" name="otsing" id="otsing" placeholder="Nimi | Eriala | Isikukood">
    <input type="submit" value="OK">
</form>
<?php
// Otsingu tulemuste kuvamine
if(!empty($_POST['otsing'])){
    $tulemus=erialaOtsing($_POST['otsing']);

      echo "  <table>
    <tr>
        <th>Õpilase nimi</th>
        <th>Isikukood</th>
        <th>Eriala</th>
        <th>Aine</th>
        <th>Pilt</th>
        <th>Elukoht</th>
    </tr>";
foreach($tulemus as $opilane){
            echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
        echo "<td>";
        foreach ($opilane->aine as $aine) {
            echo $aine->nimetus." (".$aine->hinne.")<br>";
        }
        echo "</td>";

        echo "<td><img src='".$opilane->pilt."'></td>";
        echo "<td>".$opilane->elukoht->linn.", ".
            $opilane->elukoht->maakond."</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
<hr>
<h2>Õpilaste nimekiri</h2>
<br>
<table>
    <tr>
        <th>
            Õpilase nimi
        </th>
        <th>
            Isikukood
        </th>
        <th>
            Eriala
        </th>
        <th>
            Aine
        </th>
        <th>
            Pilt
        </th>
        <th>
            Elukoht
        </th>
    </tr>
    <?php
    foreach ($opilased->opilane as $opilane) {
        echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
        echo "<td>";
        foreach ($opilane->aine as $aine) {
            echo $aine->nimetus . " (" . $aine->hinne . ")<br>";
        }
        echo "</td>";

        echo "<td><img src='".$opilane->pilt."'></td>";
        echo "<td>".$opilane->elukoht->linn.",".$opilane->elukoht->maakond."</td>";
        echo "</tr>";
    }
    ?>
</table>

<hr>
<h2>Õpilase sisestamine</h2>
<table>
    <form action="" method="post" name="vorm1">
        <tr>
            <td><label for="nimi">Nimi:</label></td>
            <td><input type="text" name="nimi" id="nimi" ></td>
        </tr>
        <tr>
            <td><label for="eriala">Eriala:</label></td>
            <td><input type="text" name="eriala" id="eriala" ></td>
        </tr>

        <tr>
            <td><label for="isikukood">Isikukood:</label></td>
            <td><input type="number" name="isikukood" id="isikukood" ></td>
        </tr>
        <tr>
        <td>Aine 1:</td>
        <td><input type="text" name="aine1"></td>
        </tr>
        <tr>
            <td>Hinne 1:</td>
            <td><input type="number" name="hinne1" min="1" max="5"></td>
        </tr>

        <tr>
            <td>Aine 2:</td>
            <td><input type="text" name="aine2"></td>
        </tr>
        <tr>
            <td>Hinne 2:</td>
            <td><input type="number" name="hinne2" min="1" max="5"></td>
        </tr>
        <tr>
            <td><label for="pilt">Pilt (URL):</label></td>
            <td><input type="text" name="pilt" id="pilt" ></td>
        </tr>
        <tr>
            <td><label for="linn">Linn</label></td>
            <td><input type="text" name="linn" id="linn" ></td>
        </tr>
        <tr>
            <td><label for="maakond">Maakond:</label></td>
            <td><input type="text" name="maakond" id="maakond" ></td>
        </tr>

        <tr>
            <td><input type="submit" name="submit" id="submit" value="Sisesta"></td>
            <td></td>
        </tr>
    </form>
</table>
</body>
</html>