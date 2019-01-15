<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$firebase = (new Factory)->create();

$host = "host = ec2-23-21-201-12.compute-1.amazonaws.com";
$user = "user = bqgtvmqhgoocpi";
$password = "password = 2302bdf02990ee73a5a3f718a2b0ca280f65f27f62ef67e6b3850e05c1eceb37";
$dbname = "dbname = df4d3civge3daf";
$port = "port = 5432";

$db = pg_connect("$host $port $dbname $user $password");
// $str = 'box_abcde';

// $read = substr($str, 4, strlen($str) - 1 );

// echo $read;

//$sql = "INSERT INTO public.basic(id) VALUES ('$id')";

// $ret = pg_query($db, $sql);

if($db){
     //survey 2
    $query1 = "SELECT answersurveytwo FROM public.survey_two_answers WHERE answersurveytwo = '1'";
    $query2 = "SELECT answersurveytwo FROM public.survey_two_answers WHERE answersurveytwo = '2'";
    $query3 = "SELECT answersurveytwo FROM public.survey_two_answers WHERE answersurveytwo = '3'";
    $query4 = "SELECT answersurveytwo FROM public.survey_two_answers WHERE answersurveytwo = '4'";
 
 
    $amt1 = 0;
    $amt2 = 0;
    $amt3 = 0;
    $amt4 = 0;

    $result1 = pg_query($db, $query1);
    $result2 = pg_query($db, $query2);
    $result3 = pg_query($db, $query3);
    $result4 = pg_query($db, $query4);

    while ($row = pg_fetch_assoc($result1)) {
        $amt1++;
    }

    while ($row = pg_fetch_assoc($result2)) {
        $amt2++;
    }

    while ($row = pg_fetch_assoc($result3)) {
        $amt3++;
    }

    while ($row = pg_fetch_assoc($result4)) {
        $amt4++;
    }

    // echo "Jumlah Pilihan 1 = \n" . $amt1;
    // echo "Jumlah Pilihan 2 = \n" . $amt2;
    // echo "jumlah Pilihan 3 = \n" . $amt3;
    // echo "Jumlah Pilihan 4 = \n" . $amt4;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Survey Kebersihan Selokan Mataram</title>
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
      <h1>Survey Kebersihan Selokan Mataram</h1>
      <h2>Lorem ipsum dolor sit amet, discere pericula est ne. Malis solet molestiae vis ea. Accusam blandit explicari et vel. Sit at congue albucius repudiare. Laudem splendide sed an. Nam no tale facete.</h2>
      <hr>
      <h3>Data survey rentang penilaian penduduk mengenai selokan mataram</h3>
      <br>
      <canvas id="myChart" width="1600" height="900"></canvas>
    </div>

    <input id="q1" type="text" name="name" value="<?php echo htmlspecialchars($amt1); ?>">
	<input id="q2" type="text" name="name" value="<?php echo htmlspecialchars($amt2); ?>">
    <input id="q3" type="text" name="name" value="<?php echo htmlspecialchars($amt3); ?>">
    <input id="q4" type="text" name="name" value="<?php echo htmlspecialchars($amt4); ?>">
    
	<script src="graph2.js"></script>
</body>
</html>