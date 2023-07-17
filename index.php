<?php

require_once('UserStats.php');

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];
    $totalClicks = $_POST['totalClicks'] > 0 ? $_POST['totalClicks'] : null;

    $userStats = new UserStats();
    $stats = $userStats->getStats($dateFrom, $dateTo, $totalClicks);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adoclic mysql</title>

    <style>
        body{
            font-family: sans-serif;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td{
            padding: 10px;
            text-align: left;
            border: 1px solid;
        }
    </style>
</head>
<body>
<h1>Estadísticas de usuarios:</h1>
<hr>

<form method="post">
    <label>Fecha desde:</label>
    <input type="date" name="dateFrom" required >
    <label>Fecha Hasta:</label>
    <input type="date" name="dateTo" required >
    <label>Clicks mayor o igual a:</label>
    <input type="number" name="totalClicks" >
    <button type="submit">Buscar</button>
</form>

<br>

<?php if(isset($stats) && !empty($stats)){ ?>

    <table>
        <tr>
            <th>Nombre y Apellido</th>
            <th>Total de vistas</th>
            <th>Total de clicks</th>
            <th>Total de conversiones</th>
            <th>Tasa de conversión</th>
            <th>Última fecha de estadísticas</th>
        </tr>
        <?php
        foreach($stats as $stat){
        ?>
        <tr>
            <td><?php echo $stat['full_name'] ?></td>
            <td><?php echo $stat['total_views'] ?></td>
            <td><?php echo $stat['total_clicks'] ?></td>
            <td><?php echo $stat['total_conversions'] ?></td>
            <td><?php echo $stat['cr'] ?></td>
            <td><?php echo $stat['last_date'] ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
}else{
    ?>
<p>No se encontraron resultados</p>
<?php
}
?>



</body>
</html>
