<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$firebase = (new Factory)->create();

$host = "host = ec2-107-20-183-142.compute-1.amazonaws.com";
$user = "user = nrtbiimbhcafvg";
$password = "password = b5a06ee5b7e826f7d8515bf4e3c0d39bb04c2e1ee5d35b223d46b37a3ebe89f7";
$dbname = "dbname = d3dfk0c84suatq";
$port = "port = 5432";

$db = pg_connect("$host $port $dbname $user $password");
// $str = 'box_abcde';

// $read = substr($str, 4, strlen($str) - 1 );

// echo $read;

//$sql = "INSERT INTO public.basic(id) VALUES ('$id')";

// $ret = pg_query($db, $sql);

if($db){
     //survey te17
    $querySosissolo = "SELECT answerte17 FROM public.survey_te17 WHERE answerte17 = 'Sosissolo'";
    $queryRotipisang = "SELECT answerte17 FROM public.survey_te17 WHERE answerte17 = 'Rotipisang'";
    $queryPisangaroma = "SELECT answerte17 FROM public.survey_te17 WHERE answerte17 = 'Pisangaroma'";
    $queryRoticoklat = "SELECT answerte17 FROM public.survey_te17 WHERE answerte17 = 'Roticoklat'";
    $queryTahubakso = "SELECT answerte17 FROM public.survey_te17 WHERE answerte17 = 'Tahubakso'";
    $queryKrakers = "SELECT answerte17 FROM public.survey_te17 WHERE answerte17 = 'Krakers'";
    $querySatebakso = "SELECT answerte17 FROM public.survey_te17 WHERE answerte17 = 'Satebakso'";
    $querySuskeju = "SELECT answerte17 FROM public.survey_te17 WHERE answerte17 = 'Suskeju'";
    $querySusufapet = "SELECT answerte17 FROM public.survey_te17 WHERE answerte17 = 'Susufapet'";
 
    $amtSosissolo = 0;
    $amtRotipisang = 0;
    $amtPisangaroma = 0;
    $amtRoticoklat = 0;
    $amtTahubakso = 0;
    $amtKrakers = 0;
    $amtSatebakso = 0;
    $amtSuskeju = 0;
    $amtSusufapet = 0;

    $resultSosissolo = pg_query($db, $querySosissolo);
    $resultRotipisang = pg_query($db, $queryRotipisang);
    $resultPisangaroma = pg_query($db, $queryPisangaroma);
    $resultRoticoklat = pg_query($db, $queryRoticoklat);
    $resultTahubakso = pg_query($db, $queryTahubakso);
    $resultKrakers = pg_query($db, $queryKrakers);
    $resultSatebakso = pg_query($db, $querySatebakso);
    $resultSuskeju = pg_query($db, $querySuskeju);
    $resultSusufapet = pg_query($db, $querySusufapet);

    while ($row = pg_fetch_assoc($resultSosissolo)) {
        $amtSosissolo++;
    }

    while ($row = pg_fetch_assoc($resultRotipisang)) {
        $amtRotipisang++;
    }

    while ($row = pg_fetch_assoc($resultPisangaroma)) {
        $amtPisangaroma++;
    }

    while ($row = pg_fetch_assoc($resultRoticoklat)) {
        $amtRoticoklat++;
    }

    while ($row = pg_fetch_assoc($resultTahubakso)) {
        $amtTahubakso++;
    }

    while ($row = pg_fetch_assoc($resultKrakers)) {
        $amtKrakers++;
    }

    while ($row = pg_fetch_assoc($resultSatebakso)) {
        $amtSatebakso++;
    }

    while ($row = pg_fetch_assoc($resultSuskeju)) {
        $amtSuskeju++;
    }

    while ($row = pg_fetch_assoc($resultSusufapet)) {
        $amtSusufapet++;
    }

    // echo "Jumlah 1 = \n" . $amtTamanJogjaIndah;
    // echo "Jumlah 2 = \n" . $amtTamanIndahJogja;
    // echo "jumlah 3 = \n" . $amtJogjaTamanIndah;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Survey TE17</title>
    <!-- CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/responsive.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <!-- logo -->
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
	
</head>
<body>
<header id="header">
        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="col-sm-9 col-xs-4">
                        <a href="../index.html"><img id='logo' src="../images/logo3.png" alt="E-Chan"></a>
                    </div>
                    <div class="col-sm-3 col-xs-8">
                        <div class="search">
                            <form role="form">
                                <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                                <i class="fa fa-search"></i>
                            <form>
                       </div>
                    </div>
            </div><!--/.container-->
        </nav><!--/nav-->
        
    </header><!--/header-->

    <div class="wrapper">
      <h1>Survey TE17</h1>
      <h3>Data survey iseng-iseng utk TE17</h3>
      <br>
      <canvas id="myChart" width="1600" height="900"></canvas>
    </div>

    <input id="Sosissolo" type="text" name="name" value="<?php echo htmlspecialchars($amtSosissolo); ?>">
	<input id="Rotipisang" type="text" name="name" value="<?php echo htmlspecialchars($amtRotipisang); ?>">
    <input id="Pisangaroma" type="text" name="name" value="<?php echo htmlspecialchars($amtPisangaroma); ?>">
    <input id="Roticoklat" type="text" name="name" value="<?php echo htmlspecialchars($amtRoticoklat); ?>">
	<input id="Tahubakso" type="text" name="name" value="<?php echo htmlspecialchars($amtTahubakso); ?>">
    <input id="Krakers" type="text" name="name" value="<?php echo htmlspecialchars($amtKrakers); ?>">
    <input id="Satebakso" type="text" name="name" value="<?php echo htmlspecialchars($amtSatebakso); ?>">
	<input id="Suskeju" type="text" name="name" value="<?php echo htmlspecialchars($amtSuskeju); ?>">
    <input id="Susufapet" type="text" name="name" value="<?php echo htmlspecialchars($amtSusufapet); ?>">
    
	<script src="graph.js"></script>
</body>
</html>