<?php
$page = $_SERVER['PHP_SELF'];
$sec = "10";
?>
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<head>
<meta http-equiv="refresh" content="15">
  <title>Gallery</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<h2 class="text-center">Status of jobs completed</h1>

<body>
<div class="container">
<div class="row">
<?php
session_start();
require 'vendor/autoload.php';

use Aws\Rds\RdsClient;
$rds = new Aws\Rds\RdsClient([
        'version' => 'latest',
        'region'  => 'us-west-2'
]);

$result = $rds->describeDBInstances([
        'DBInstanceIdentifier' => 'zsayed1-read-db',
]);
$endpoint = "";
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
#print "\n============\n" . $endpoint . "\n================\n";

//echo "begin database";
$link = mysqli_connect($endpoint,"zsayed1","password","test_2") or die("Error " . mysqli_error($link));

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
//link created
$link->real_query("SELECT id,status FROM records");
$res = $link->use_result();
echo "<table class='table'>
<thead>
<tr>
<th>id</th>
<th>status</th>
</tr>
</thead>
<tbody>";
while ($row = $res->fetch_assoc()) {
    echo "<tr>";
    echo "<th scope='row'>" . $row['id'] . "</th>";
    echo "<td>" . $row['status'] . "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
$link->close();
?>                      
</div>
</div>
</body>
</html>


