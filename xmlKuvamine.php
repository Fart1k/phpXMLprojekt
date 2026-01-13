<?php
$opilased = simplexml_load_file('opilased.xml');
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

<?php
//1.Õpilase nimi
echo "1.Õpilase nimi: ".$opilased->opilane[0]->nimi;
?>

</body>
</html>
