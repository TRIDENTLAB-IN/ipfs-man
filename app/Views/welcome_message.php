<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IPFS-PUBLIC-GATEWAY</title>
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
  <section class="container-fluid ">
    <div class="row">
      <div class="col-lg-6">
    <div class="card border-0">

      <div class="card-body border-0">
        <h6>bandwidth</h6>
        <canvas id="bandwidth_graph">
        </canvas>

      </div>

    </div>
    </div>
    </div>

  </section>

<?php
  $ttbw = json_decode(file_get_contents(FCPATH."static/data/ttbw.json"));
  $tdbw = json_decode(file_get_contents(FCPATH."static/data/tdbw.json"));
  $bandwidth = array_merge($ttbw,$tdbw);



?>
<script>
var old_bandwidth = JSON.parse('<?php echo json_encode($bandwidth);?>');
</script>









<script src="static/js/dashboard.js" type="text/javascript"></script>

</body>

</html>
