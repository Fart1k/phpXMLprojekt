<?php
require ("funktsioonid.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>XML faili kuvamine funktioonide abil</title>
</head>
<body>
<h1>RSS uudised</h1>

<?php
uudised('https://www.err.ee/rss', 5);
?>

<h1>Postimees RSS uudised</h1>

<?php
//feeds2.feedburner.com/delfieesti
uudised('https://www.postimees.ee/rss', 3);
?>

</body>
</html>