<?php
# php script to get aws cloudwatch data and format output
# for nagios check
# can be expanded to get Metrics from all AWS namespaces
# requires aws cli configured and aws sdk for php
# http://docs.aws.amazon.com/cli/latest/userguide/cli-chap-getting-started.html
# http://docs.aws.amazon.com/aws-sdk-php/v3/guide/getting-started/index.html
 
require 'vendor/autoload.php';
use Aws\CloudWatch\CloudWatchClient;
$client = CloudWatchClient::factory(array(
    'profile' => 'default',
    'region' => 'us-west-2'
));

## defining variables to pass in Getmetrics
$dimensions = array(
    array('Name' => 'InstanceId', 'Value' => 'i-abcdef'),
);
date_default_timezone_set ("UTC");
$end_time = date('c');
$date = date_create(date('c'));
date_sub($date, date_interval_create_from_date_string('15 minute'));
$start_time = date_format($date, 'c');
########################################################################################
# get command line arguments
$options = getopt("w:c:");
if (!$options['w'] || !$options['c'])
{ 
  echo "Usage: $argv[0] -w<warning range> -c<critical range>\n";
  exit (-1);
}
$warnings = explode(':', $options['w']);
if (count($warnings) == 2)
{
  $warn_low = $warnings[0];
  $warn_high = $warnings[1];
} else
{
  $warn_low = 0;
  $warn_high = $warnings[0];
}
 
$criticals = explode(':', $options['c']);
if (count($criticals) == 2)
{
  $crit_low = $criticals[0];
  $crit_high = $criticals[1];
} else
{
  $crit_low = 0;
  $crit_high = $criticals[0];
}
 
########################################################################################
# get metric data
$result = $client->getMetricStatistics(array(
    'Namespace'  => 'AWS/EC2',
    'MetricName' => 'CPUUtilization',
    'Dimensions' => $dimensions,
    'StartTime'  => $start_time,
    'EndTime'    => $end_time,
    'Period'     => 360,
    'Statistics' => array('Average', ),
));
# get cpu average
$result_count = count($result['Datapoints']) - 1;
if ($result_count < 0) { $result_count = 0; }
$cpu_avg = $result['Datapoints'][$result_count]['Average'];
# compare cpu average with argv
# and exit
# TODO write timer event to return UNKNOWN if timeout > 5sec
# requires eio extention
#
#$base = new EventBase();
#$n = 2;
#$e = Event::timer($base, function($n) use (&$e) {
#    echo "$n seconds elapsed\n";
#    $e->delTimer();
#    exit (3);
#}, $n);
#$e->addTimer($n);
#$base->loop();
#print_r($result);
if (!is_numeric($warn_low) || !is_numeric($warn_high))
{
  echo "bad arguments\n";
  exit (-1);
}
if (!is_numeric($crit_low) || !is_numeric($crit_high))
{
  echo "bad arguments\n";
  exit (-1);
}
if ($cpu_avg > $crit_high || $cpu_avg < $crit_low)
{
  echo "*CRITICAL* - Cpu Utilization: " . $cpu_avg . "% | CpuUtilization%=" . $cpu_avg;
  echo "\n";
  exit (2);
}
if ($cpu_avg > $warn_high || $cpu_avg < $warn_low)
{
  echo "*WARNING* - Cpu Utilization: " . $cpu_avg . "% | CpuUtilization%=" . $cpu_avg;
  echo "\n";
  exit (1);
}
echo "OK - Cpu Utilization: " . $cpu_avg . "% | CpuUtilization%=" . $cpu_avg;
echo "\n";
exit (0);

?>