<?php

function LisaOpilane()
{
    $xmlDoc = new DOMDocument("1.0", "UTF-8");
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->load("opilased.xml");
    $xmlDoc->formatOutput = true;
    $xmlOpilane = $xmlDoc->createElement("opilane");
    $xmlDoc->appendChild($xmlOpilane);
    $xmlRoot = $xmlDoc->documentElement;
    $xmlRoot->appendChild($xmlOpilane);
    $elukoht = $xmlDoc->createElement("elukoht");
    $xmlOpilane->appendChild($elukoht);
    unset($_POST["submit"]);
    foreach ($_POST as $voti => $vaartus)
    {
        $kirje = $xmlDoc->createElement($voti, $vaartus);

        if ($voti == "linn" || $voti == "maakond")
            $elukoht->appendChild($kirje);
        else
            $xmlOpilane->appendChild($kirje);
    }

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
        } else if (substr(strtolower($opilane->nimi), 0, strlen($paring))
            == strtolower($paring)) {
            array_push($tulemus, $opilane);
        } else if (substr(strtolower($opilane->isikukood), 0, strlen($paring))
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
        <th>Elukoht</th>
    </tr>";
foreach($tulemus as $opilane){
            echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
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
            Elukoht
        </th>
    </tr>
    <?php
    foreach ($opilased->opilane as $opilane) {
        echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->isikukood."</td>";
        echo "<td>".$opilane->eriala."</td>";
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
            <td><input type="text" name="isikukood" id="isikukood" ></td>
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