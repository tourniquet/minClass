<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <?php
    require_once('../config.php');

    $dbc = mysqli_connect(
      DB_HOST,
      DB_USER,
      DB_PASSWORD,
      DB_NAME
    ) or Die('Error connecting to database');
    
    $ad_id = $_GET['id'];
    $query = "SELECT * FROM cls_ads WHERE id = $ad_id";
    $res = mysqli_query($dbc, $query);

    if (mysqli_connect_errno($dbc)) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }

    while ($row = mysqli_fetch_array($res)) {
      $disable_ad = "UPDATE cls_ads SET enabled = 0 WHERE id = $ad_id";
      $data = mysqli_query($dbc, $disable_ad);

      echo '<h3>Your ad ' . $row['title'] . ' was disabled!</h3';
    }

    mysqli_close($dbc);
  ?>
  
  <div>
    <a href="/classified/backend/admin"><<< Back</a>
  </div>
</body>
</html>
