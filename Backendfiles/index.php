<?php
session_start();
?>


<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="C:\Users\HP\Desktop\a\materialize\css\materialize.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 

 <head>
  <title>Cloud Analysis </title>

  <style>
p
   {
    padding-top: 360px;
    padding-right: 30px;
    padding-bottom: 70px;
    padding-left: 80px;
    text-align: center;
    font-size: 40px;
    font-family: sans-serif;

   
}

.bttn{
    background-color: #4fc3f7;	
margin-left:5cm;
}

.bttn1{
background-color: #4fc3f7;
bottom-left:5cm;
}


.topleft {
    position: absolute;
    top: 20%;
    right:27cm;
    font-size: 18px;
}


.topleft1 {
    position: absolute;
    top: 35%;
    left:5cm;
    font-size: 18px;
}

body { 
    background-image: url('https://s3-us-west-2.amazonaws.com/zsayed1index/pittcon-informatics-2017-286679.png');
    background-repeat: no-repeat;
    
    background-position: center; 
 
}

#Gallery {
    font-size: 50px;
    background-color: grey;
}

</style>
  </head>
  <body>

    <p style="color:#e0f7fa">Cloud Watch Application </p>

    <div class="selection" style="text-align: center">
 

<div class="button">
<form action="SqsWatch.php">
  <button class="btn waves-effect waves-light btn-large bttn topleft" type="submit" name="action">SQS
    <i class="material-icons right">border_color</i>
  </button>
        </form>


         <div class="button">
 <form action="CloudWatch.php">
<button class="btn waves-effect waves-light btn-large bttn1 topleft1" type="submit" name="action">RDS
 <i class="material-icons right">panorama</i>
 </button>
         </form>
 
         <!-- <a class="button" id="Gallery" href="file:///?C:\wamp64\www\Gallery.php" target="_blank"> Gallery</a>
    <a class="button" id="Gallery" href="file:///?C:\wamp64\www\Form.php" target="_blank"> Form </a>
  --></div>

</div>
  </body>

</html>
