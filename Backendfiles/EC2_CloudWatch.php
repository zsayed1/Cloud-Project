<?php
require 'vendor/autoload.php';
echo "hello world!\n";
$cw = new Aws\CloudWatch\CloudWatchClient([
    'version' => 'latest',
    'region'  => 'us-west-2'
]);
/*$cpuresult = $cw->getMetricStatistics([
  'Dimensions' => [
      [
        'Name' => 'InstanceId',
        'Value' => 'i-0a55fe5b7ba373188'
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
echo "Minimum: " . $cpuresult['Datapoints'][0]['Minimum'] . "\n";
echo "Maximum: " . $cpuresult['Datapoints'][0]['Maximum'] . "\n";
$CpuMinimum= $cpuresult['Datapoints'][0]['Minimum'];
$CpuMaximum= $cpuresult['Datapoints'][0]['Maximum'];
*/
//$queueurl = $listQueueresult['QueueUrls'][0];


/*$DiskReadresult = $cw->getMetricStatistics([
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
      'StartTime' => strtotime('-1 days'), // REQUIRED
      'Statistics' => ['Sum'],
      'Unit' => 'Bytes',
  ]);
  print_r($DiskReadresult);

  echo "Sum of data in one day " . $DiskReadresult['Datapoints'][0]['Sum'] . "\n";
  $SumDiskReadBytes = $DiskReadresult['Datapoints'][0]['Sum'];*/
/*
  $DiskReadOps = $cw->getMetricStatistics([
    'Dimensions' => [
        [
          'Name' => 'InstanceId',
          'Value' => 'i-0a55fe5b7ba373188'
        ],
      ],
      'EndTime' => strtotime('now'), // REQUIRED
      'MetricName' => 'DiskReadOps', // REQUIRED
      'Namespace' => 'AWS/EC2', // REQUIRED
      'Period' => 60, // REQUIRED
      'StartTime' => strtotime('-1 days'), // REQUIRED
      'Statistics' => ['Maximum','Minimum'],
     // 'Unit' => '
  ]);
  
  //print_r($DiskReadOps);
  echo "Minimum: " . $DiskReadOps['Datapoints'][0]['Minimum'] . "\n";
  echo "Maximum: " . $DiskReadOps['Datapoints'][0]['Maximum'] . "\n";
  $DiskReadOpsMin= $DiskReadOps['Datapoints'][0]['Minimum'];
  $DiskReadOpsMax= $DiskReadOps['Datapoints'][0]['Maximum'];
*/
/*
  $DiskWriteOps = $cw->getMetricStatistics([
    'Dimensions' => [
        [
          'Name' => 'InstanceId',
          'Value' => 'i-0a55fe5b7ba373188'
        ],
      ],
      'EndTime' => strtotime('now'), // REQUIRED
      'MetricName' => 'DiskWriteOps', // REQUIRED
      'Namespace' => 'AWS/EC2', // REQUIRED
      'Period' => 60, // REQUIRED
      'StartTime' => strtotime('-1 days'), // REQUIRED
      'Statistics' => ['Maximum','Minimum'],
     // 'Unit' => '
  ]);
  
 // print_r($DiskWriteOps);
  echo "Minimum: " . $DiskWriteOps['Datapoints'][0]['Minimum'] . "\n";
  echo "Maximum: " . $DiskWriteOps['Datapoints'][0]['Maximum'] . "\n";
  $MinDiskWriteOps= $DiskWriteOps['Datapoints'][0]['Minimum'];
  $MaxDiskWriteOps= $DiskWriteOps['Datapoints'][0]['Maximum'];
*/
/*
$DiskWriteBytes = $cw->getMetricStatistics([
  'Dimensions' => [
      [
        'Name' => 'InstanceId',
        'Value' => 'i-004b1918ca2234e29'
      ],
    ],
    'EndTime' => strtotime('now'), // REQUIREDer
    'MetricName' => 'DiskWriteBytes', // REQUIRED
    'Namespace' => 'AWS/EC2', // REQUIRED
    'Period' => 60, // REQUIRED
    'StartTime' => strtotime('-1 days'), // REQUIRED
    'Statistics' => ['Sum'],
    'Unit' => 'Count',
]);
print_r($DiskWriteBytes);

echo "Sum of data in one day " . $DiskWriteBytes['Datapoints'][0]['Sum'] . "\n";
$SumDiskWriteBytes = $DiskWriteBytes['Datapoints'][0]['Sum'];
*/

$NetworkIn = $cw->getMetricStatistics([
  'Dimensions' => [
      [
        'Name' => 'InstanceId',
        'Value' => 'i-004b1918ca2234e29'
      ],
    ],
    'EndTime' => strtotime('now'), // REQUIREDer
    'MetricName' => 'NetworkIn', // REQUIRED
    'Namespace' => 'AWS/EC2', // REQUIRED
    'Period' => 60, // REQUIRED
    'StartTime' => strtotime('-1 days'), // REQUIRED
    'Statistics' => ['Minimum','Maximum'],
    'Unit' => 'Bytes',
]);
print_r($NetworkIn);

echo "Sum of data in one day " . $NetworkIn['Datapoints'][0]['Minimum'] . "\n";
$MinNetworkIn = $NetworkIn['Datapoints'][0]['Minimum'];
  ?>
