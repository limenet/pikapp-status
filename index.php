<?php
require_once 'vendor/autoload.php';

use \Curl\Curl;


try {
    $curl = new Curl();
    $curl->post('https://api.uptimerobot.com/v2/getMonitors',
        [
            'api_key' => 'm776065506-7de96c4fb4595bd6aefce078',
            'format' => 'json',
            'response_times' => true,
            'timezone' => true,
            'custom_uptime_ratios' => '1',
        ]
    );

    if ($curl->error) {
        throw new Exception();
    }

    //Output json_decoded contents
    $status = $curl->response->monitors[0]->status;
    $uptime = $curl->response->monitors[0]->custom_uptime_ratio.'%';
    $responseTime = $curl->response->monitors[0]->average_response_time.'ms';
} catch (Exception $e) {
    $status = -1;
}

switch ($status) {
    case '2':
        $text = 'pikapp is UP!';
        $color = 'green';
        break;
    case '8':
        $text = 'pikapp might be down';
        $color = 'orange';
        break;
    case '9':
        $text = 'pikapp is DOWN. Sorry!';
        $color = 'red';
        break;
    case '-1':
        $uptime = '&mdash;';
        $responseTime = '&mdash;';
    case '0':
    default:
        $text = 'Uptime not available';
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

    <title>pikapp Status</title>

    <link href="bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Source+Code+Pro' rel='stylesheet' type='text/css'>

    <style>
        /*
        http://www.google.ch/design/spec/style/color.html#color-color-palette
        bg: 500;
        text: 700;
         */

        .container {padding-top: 40px;}
        .bg-status-grey {background-color: #9E9E9E;}
        .bg-status-green {background-color: #4CAF50;}
        .bg-status-orange {background-color: #FF9800;}
        .bg-status-red {background-color: #F44336;}

        .text-status-grey {color: #616161;}
        .text-status-green {color: #388E3C;}
        .text-status-orange {color: #F57C00;}
        .text-status-red {color: #D32F2F;}
        .text-monospace {font-family: "Source Code Pro", "Consolas", monospace;}

        h1{font-size: 200px;}
        h2{font-size: 100px;}
        h3{font-size: 50px;}
        body {font-family: "Source Sans Pro", "Helvetica", "Arial", sans-serif;}
    </style>
  </head>
  <body class="bg-status-<?=$color?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="text-status-<?=$color?>"><?=$text?></h1>
                <h2 class="text-status-<?=$color?> text-monospace"><?=$uptime?> | <?=$responseTime?></h2>
            </div>
        </div>
    </div>
  </body>
</html>
