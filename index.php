<?php
//Requires composer install to work
require_once('/PHP-UptimeRobot/src/UptimeRobot/API.php');

use UptimeRobot\API;

//Set configuration settings
$config = array(
    'apiKey' => 'm775682179-dbdadbde5e38295028240b7c',
    'url' => 'http://api.uptimerobot.com'
);

try {

    //Initalizes API with config options
    $api = new API($config);

    //Define parameters for our getMethod request
    $args = [
        'showTimezone' => 1
    ];

    //Makes request to the getMonitor Method
    $results = $api->request('/getMonitors', $args);

    //Output json_decoded contents
    $status = $results['monitors']['monitor'][0]['status'];

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
        # code...
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
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet"> -->


    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .container {
            padding-top: 40px;
        }
        .bg-status-grey{
            background-color: #95a5a6;
        }
        .bg-status-green{
            background-color: #2ecc71;
        }
        .bg-status-orange{
            background-color: #e67e22;
        }
        .bg-status-red{
            background-color: #e74c3c;
        }

        .text-status-grey{
            color: #7f8c8d;
        }
        .text-status-green{
            color: #27ae60;
        }
        .text-status-orange{
            color: #d35400;
        }
        .text-status-red{
            color: #c0392b;
        }
        h1{
            font-size: 100px;
        }
    </style>
  </head>

  <body class="bg-status-<?=$color?>">

    <div class="container">

        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="text-status-<?=$color?>">pikapp is <?=strtoupper($text)?></h1>
            </div>
        </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script> -->
  </body>
</html>
