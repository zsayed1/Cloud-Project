<?php
session_start();
ob_start();
?>

<html>
<head>
  <title>Submitting test_2</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<?php
require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Imagick;
$uploaddir = '/tmp/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
	{
		echo "File uploaded.\n";
	}
	else
	{
		echo "Error uploading the file\n";
	}
print "</pre>";


$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);


$bucket='zsayed1before1';


$result = $s3->putObject([
    'ACL' => 'public-read',
    'Bucket' => $bucket,
    'Key' =>  basename($_FILES['userfile']['name']),
    'SourceFile' => $uploadfile

]);

$url=$result['ObjectURL'];

echo "\n". "Created URL is : " . $url ."\n";


$sqs = new Aws\Sqs\SqsClient([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);

#list the SQS Queue URL
$listQueueresult = $sqs->listQueues([
    
]);
# print out every thing
# print_r ($listQueueresult);  

echo "Your SQS URL is: " . $listQueueresult['QueueUrls'][0] . "\n";
$queueurl = $listQueueresult['QueueUrls'][0];

### 
# you need some code to insert records into the database -- make sure you retrieve the UUID into a variable so you can pass it to the SQS message

//Changed --zeshan

use Aws\Rds\RdsClient;
$rds = new Aws\Rds\RdsClient([
        'version' => 'latest',
        'region'  => 'us-west-2'
]);


$result = $rds->describeDBInstances([
        'DBInstanceIdentifier' => 'zsayed1-db',
]);


$endpoint = "";
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
//echo "begin database";
$link = mysqli_connect($endpoint,"zsayed1","password","test_2",3306) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



if (!($stmt = $link->prepare("INSERT INTO records (id,uname,email,phone,s3rawurl,s3finishedurl,status,receipt) VALUES (NULL,?,?,?,?,?,?,?)"))) {
	echo "Prepare failed: (" . $link->errno . ") " . $link->error;
}
$email = $_POST['useremail'];
$uname = $_POST['uname'];
$phone = $_POST['phone'];
$s3rawurl = $url; //  $result['ObjectURL']; from above
$filename = basename($_FILES['userfile']['name']);
$s3finishedurl = "";
$status =0;
$receipt=1;

$stmt->bind_param("ssssssi",$uname,$email,$phone,$s3rawurl,$s3finishedurl,$status,$receipt); // 6 strings & 1 integer ssssssi
if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
printf("%d Rows aded to the database.\n", $stmt->affected_rows);





$link->real_query("SELECT id FROM records where s3rawurl = '$url'");
$res = $link->use_result();
while ($row = $res->fetch_object()) {
   $uuid = $row->id;
}

$link->close();


//--zeshan


##echo $uuid . '\n';

### send message to the SQS Queue
$sendmessageresult = $sqs->sendMessage([
    'DelaySeconds' => 30,
    'MessageBody' => $uuid, // REQUIRED
    'QueueUrl' => $queueurl // REQUIRED
]);

echo "The messageID is: ". $sendmessageresult['MessageId'] . "\n";
$sqs = new Aws\Sns\SnsClient([
    'version' => 'latest',
    'region' => 'us-west-2' //regionus0west-2
]);


//creating variable to store the list of Topic arn
$result = $sqs->listTopics([

]);

print_r($result['Topics']);
$topicarn=($result['Topics'][0]['TopicArn']);
echo "Your Topic Arn: . $topicarn";

//subscribing sns
$subscribe = $sqs->subscribe([
    'Endpoint' => $email,
    'Protocol' => 'email',
    'TopicArn' => $topicarn, 
]);

?>
</body>
</html>

<?php
header('Location: index.php');
ob_end_flush();
?>
