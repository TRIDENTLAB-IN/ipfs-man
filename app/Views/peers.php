<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Peers</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">

    <link rel="stylesheet" type="text/css" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="static/css/skin.css">
    <script src="static/js/jquery.min.js" type="text/javascript"></script>
    <script src="static/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="static/js/chart.v4.js" type="text/javascript"></script>

</head>
<body >
  <table class="table table-striped">


  <?php

  foreach ($peer_list as  $peer_info) {

    echo '<tr>
      <th scope="row"></th>
      <td><span class="cc" data-cc="'.$peer_info["cc"].'"></span> '.$peer_info["location"].'/'.$peer_info["cc"].'</td>
      <td>'.$peer_info["peerid"].'</td>
      <td>'.$peer_info["latency"].'ms</td>
      <td>'.date("h:i A, d-M-Y ,D",$peer_info["pubtime"]).'</td>


    </tr>';
  }


  ?>
</table>
<script src="static/js/peers.js" type="text/javascript"></script>
  </body>

  </html>
