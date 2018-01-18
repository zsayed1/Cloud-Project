#!/bin/bash

###ecurity grup
##2 = keyname
##1 = imageID
## SG = security group
###4 = LoadBalancerName

if [ "$#" -ne 5 ]; then
   echo "Hello"
   echo /n "The following parameters are needed to run this shell script:"
   echo /n "1) Ami-id"
   echo /n "2) Key-name"
   echo /n "3) Security-group"
   echo /n "4) launch-configuration: Give any name"
   echo /n "5) IAM profile"
   exit 0
else
echo "all parameters conditions are matching ..we can go ahead"
fi

##Creating AWS RDS INSTANCE

aws rds create-db-instance --db-name test_2 --db-instance-identifier zsayed1-db --db-instance-class db.t2.micro --engine mysql  --master-username zsayed1 --master-user-password password --allocated-storage 5 --publicly-accessible --availability-zone us-west-2a

#aws rds create-db-instance --db-name test_2 --db-instance-identifier zsayed1-db --allocated-storage 5 --db-instance-class db.t2.micro --engine mysql --master-username zsayed1 --master-user-password password --availability-zon
##e us-west-2a --vpc-security-group-ids $SG --publicly-accessible

#Wait Untill Database is created
aws rds wait db-instance-available --db-instance-identifier zsayed1-db

#Create an EndPoint
DBEndpoint=(`aws rds describe-db-instances --output text | grep ENDPOINT | awk 'NR==1{print $2}'`);
echo $DBEndpoint

#Create table if not created by setup.php
        # Connect to DB instance
                # Connect to database
                        # Create a table
                                # Show Schema

mysql -h $DBEndpoint -P 3306  --user=zsayed1 --password=password  << EOF

use test_2;

CREATE TABLE IF NOT EXISTS records (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, uname VARCHAR(20) NOT NULL, email VARCHAR(20) NOT NULL, phone VARCHAR(20) NOT NULL, s3rawurl VARCHAR(255) NOT NULL, s3finishedurl VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, status TINYINT(3)CHECK(state IN(0,1,2)), receipt BIGINT);
show tables;

EOF

aws ec2 run-instances --image-id $1 --key-name $2 --security-groups $3 --instance-type t2.micro  --iam-instance-profile Name=$5 --monitoring Enabled=TRUE --user-data file://install-backend-env.sh 

##To get Security group id
SG=`aws ec2 describe-security-groups | grep $3 | awk '{print $3}'`

##Create Load Balancer
aws elb create-load-balancer --load-balancer-name $4 --listeners "Protocol=HTTP,LoadBalancerPort=80,InstanceProtocol=HTTP,InstancePort=80" --security-groups $SG --availability-zones us-west-2a

## describe load balancer
LB=`aws elb describe-load-balancers | awk 'NR==1{print $6}'`

# Create sticky bits
aws elb create-lb-cookie-stickiness-policy --load-balancer-name $4 --policy-name policy1 --cookie-expiration-period 60

## wait command for load blancers
##aws elb wait any-instance-in-service --load-balancer-name $4

##create Launcg configuration
aws autoscaling create-launch-configuration --launch-configuration-name lc_4 --image-id $1 --instance-type t2.micro --key-name $2 --security-groups $3 --user-data file://install-app-env.sh --iam-instance-profile $5

## create auto scaling group
aws autoscaling create-auto-scaling-group --auto-scaling-group-name ac_4 --launch-configuration-name lc_4 --min-size 3 --max-size 3 --load-balancer-name $4 --availability-zones us-west-2a

##creating before bucket
aws s3 mb s3://zsayed1before1

##Create SQS 
aws sqs create-queue --queue-name itmo-544
##creating before bucket
aws s3 mb s3://zsayed1after1
##Creating read replica of the db
aws rds create-db-instance-read-replica --db-instance-identifier zsayed1-read-db --source-db-instance-identifier zsayed1-db
##Wait command for  read replica
aws rds wait db-instance-available --db-instance-identifier zsayed1-read-db