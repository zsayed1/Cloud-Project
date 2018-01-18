## Command:

./create-env.sh ***ami-fafe2582*** keyName securityGroup loadbalancerName instanceProfileRole



## Assumptions with RDS
* No other db instance running becuase awk command is used to get db instances.
* ***VPC*** group passed to the RDS instance i.e. the default vpc should have HTTP, MYSQL enabled.

## Assumption with installed machine:
* Mysql is already installed on the machcine
* chmod 400 rights are already given to install-ap.sh script
* iam role is assigned to policies like 
      * PowerUser Acess
      * S3 Full acess
      * RDS full acess
      * EC2 full acess

## Assumptions with S3:
* no s3 bucket with zsayed1before1 and zsayed1after1 should be already present in the installers s3 bicket list
