<?php

if (!function_exists('curl_init')) {
    throw new Exception('APP needs the cURL PHP extension.');
}

//Requires composer install to work
require_once(__DIR__.'/vendor/autoload.php');

use UptimeRobot\API;


//Set configuration settings
$config = array(
    'apiKey' => 'm776065506-7de96c4fb4595bd6aefce078',
    'url' => 'http://api.uptimerobot.com'
);

try {

    //Initalizes API with config options
    $api = new API($config);

    //Define parameters for our getMethod request
    $args = array(
        'showTimezone' => 1
    );

    //Makes request to the getMonitor Method
    $results = $api->request('/getMonitors', $args);

    //Output json_decoded contents
    $status = $results['monitors']['monitor'][0]['status'];
    $uptime = $results['monitors']['monitor'][0]['alltimeuptimeratio'];
} catch (Exception $e) {
    echo $e->getMessage();
    //Output various debug information
    var_dump($api->debug);
}
switch ($status) {
    case '2':
        $text = 'up';
        $color = 'green';
        break;
    case '8':
        $text = 'likely down';
        $color = 'orange';
        break;
    case '9':
        $text = 'down';
        $color = 'red';
        break;
    case '0':
    default:
        $text = 'paused';
        $color = 'grey';
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.ico">

    <title>[pikapp] Status</title>

    <!-- Bootstrap core CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Source+Code+Pro' rel='stylesheet' type='text/css'>
    <!-- <link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"> -->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        /*
        http://www.google.ch/design/spec/style/color.html#color-color-palette
        bg: 500;
        text: 700;
         */
        .container {
            padding-top: 40px;
        }
        .bg-status-grey {
            background-color: #9E9E9E;
        }
        .bg-status-green {
            background-color: #4CAF50;
        }
        .bg-status-orange {
            background-color: #FF9800;
        }
        .bg-status-red {
            background-color: #F44336;
        }

        .text-status-grey {
            color: #616161;
        }
        .text-status-green {
            color: #388E3C;
        }
        .text-status-orange {
            color: #F57C00;
        }
        .text-status-red {
            color: #D32F2F;
        }
        .text-monospace {
            font-family: "Source Code Pro", "Consolas", monospace;
        }
        h1{
            font-size: 200px;
        }
        h2{
            font-size: 100px;
        }
        body {
            font-family: "Source Sans Pro", "Helvetica", "Arial", sans-serif;
        }

    </style>
  </head>

  <body class="bg-status-<?=$color?>">

    <div class="container">

        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="text-status-<?=$color?>">pikapp is <?=strtoupper($text)?></h1>
                <h2 class="text-status-<?=$color?> text-monospace"><?=$uptime?>%</h2>
            </div>
        </div>

    </div><!-- /.container -->
  </body>
</html>
