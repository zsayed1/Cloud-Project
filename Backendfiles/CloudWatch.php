<?php
require 'vendor/autoload.php';
 echo "hello world!\n";
$cw = new Aws\CloudWatch\CloudWatchClient([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);
$cpuresult = $cw->getMetricStatistics([
  'Dimensions' => [
      [
        'Name' => 'InstanceId',
        'Value' => 'i-004b1918ca2234e29'
      ],
    ],
    'EndTime' => strtotime('now'), // REQUIRED
    'MetricName' => 'CPUUtilization', // REQUIRED
    'Namespace' => 'AWS/EC2', // REQUIRED
    'Period' => 60, // REQUIRED
    'StartTime' => strtotime('-15 minutes'), // REQUIRED
    'Statistics' => ['Maximum','Minimum'],
   // 'Unit' => '
]);


print_r($cpuresult);
echo "Your SQS URL is: " . $cpuresult['Label'][0] . "\n";

//$queueurl = $listQueueresult['QueueUrls'][0];


$DiskReadresult = $cw->getMetricStatistics([
    'Dimensions' => [
        [
          'Name' => 'InstanceId',
          'Value' => 'i-004b1918ca2234e29'
        ],
      ],
      'EndTime' => strtotime('now'), // REQUIREDer
      'MetricName' => 'DiskReadBytes', // REQUIRED
      'Namespace' => 'AWS/EC2', // REQUIRED
      'Period' => 60, // REQUIRED
      'StartTime' => strtotime('-5 minutes'), // REQUIRED
      'Statistics' => ['Average'],
      'Unit' => 'Bytes',
  ]);
  print_r($DiskReadresult);
  ?>
