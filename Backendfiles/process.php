<?php
require 'vendor/autoload.php';

 echo "hello world!\n";

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


$receivemessageresult = $sqs->receiveMessage([
    'MaxNumberOfMessages' => 1,
    'QueueUrl' => $queueurl, // REQUIRED
    'VisibilityTimeout' => 60,
    'WaitTimeSeconds' => 5,
]);

# print out content of SQS message - we need to retreive Body and Receipt Handle
#print_r ($receivemessageresult['Messages'])
$receiptHandle = $receivemessageresult['Messages'][0]['ReceiptHandle'];
$uuid = $receivemessageresult['Messages'][0]['Body'] . "\n";


//$uuid=4;
echo "The content of the message is: " . $receivemessageresult['Messages'][0]['Body'] . "\n";

# Now in your data base do a select * from records where uuid=$uuid;

//-zeshan
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

$link->real_query("SELECT s3rawurl FROM records where id='$uuid'");
$res = $link->use_result();
$row = $res->fetch_assoc();
$s3url= $row['s3rawurl'];

echo $s3url;


$link->close();

# Include your S3 code to retreive the object from the S3URL -- save file local in a tmp file name
//---zeshan(error) saved the filein $uploa file 



# Pass this image into your image manipulation function  

//--zeshan create s3 sclient

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);


# upon completion put the finished image into the S3 bucket for finsihed images
//chdir("var");
//chdir("www");
//chdir("html");
$uploaddir = 'after/';
echo getcwd() . "\n";
//$uploadfile=$uploaddir . basename($_FILES['userfile']['name']);
$uploadfile = tempnam('/tmp', 'upload_');
//--zeshan create $url to get object url
$url=$s3url;
$checkingformat=substr($url, -3);
if($checkingformat == 'png' || $checkingformat == 'PNG'){
    $image_raw=imagecreatefrompng($url);
}
else{
    $image_raw = imagecreatefromjpeg($url);
}
if($image_raw && imagefilter($image_raw, IMG_FILTER_GRAYSCALE))
{
    imagepng($image_raw, $uploadfile);
}
else
{
    echo 'Conversion to grayscale failed.';
}
$resultimg = $s3->putObject(array(
    'Bucket' => 'zsayed1after1',
    'Key'    =>  basename($uploadfile.'.png'),//$gray_uploaddir.basename($_FILES['userfile']['name']),
    'SourceFile' => $uploadfile,
    'ACL' => 'public-read'
));


$finishedurl=$resultimg['ObjectURL'];
imagedestroy($image_raw);


# Update your Database record using the UPDATE and the $uuid as the search term  
#  * Add S3 finsihed URL  ---zeshan



$endpoint = "";
$endpoint = $result['DBInstances'][0]['Endpoint']['Address'];
//echo "begin database";
$link = mysqli_connect($endpoint,"zsayed1","password","test_2",3306) or die("Error " . mysqli_error($link));
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
// Prepared statement, stage 1: prepare

//--zeshan

if (!($stmt = $link->prepare("UPDATE records SET s3finishedurl='$finishedurl' WHERE id='$uuid'"))) {
	echo "Prepare failed: (" . $link->errno . ") " . $link->error;
}

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
printf("%d S3 after url updated inserted into database.\n", $stmt->affected_rows);

#  * change status from 0 to 1 (done)
if (!($stmt1 = $link->prepare("UPDATE records SET status='1' WHERE id='$uuid'"))) {
	echo "Prepare failed: (" . $link->errno . ") " . $link->error;
}
if (!$stmt1->execute()) {
    echo "Execute failed: (" . $stmt1->errno . ") " . $stmt1->error;
}
printf("%d Status changed to 1 sucessfully \n", $stmt1->affected_rows);

# SNS would then send your user a text with the finsihed URL 


# delete consumed message

$deletemessageresult = $sqs->deleteMessage([
    'QueueUrl' => $queueurl, // REQUIRED
    'ReceiptHandle' => $receiptHandle, // REQUIRED
]);


# Send message


///// Creatinhg SNS client
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
$result = $sqs->publish
([
	'Subject' => 'Image changed to grayscale',
	'Message' => 'Image has been uploaded to the Gallery.', // REQUIRED
	'TopicArn' => $topicarn,
]);



?>
