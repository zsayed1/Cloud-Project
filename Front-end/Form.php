<?php
session_start();
?>


<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<head>

  <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="C:\Users\HP\Desktop\a\materialize\css\materialize.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<style>
body { 
    
    background-repeat: no-repeat;
    
    background-image:url('https://s3-us-west-2.amazonaws.com/zsayed1index/cloudcomputing-1.jpg');
    background-position: center; 
 
}
</style>

  <title>Image Processing</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<h2 align="center">Submit Form</h1>


</head>

<body>

   <script type="text/javascript" src="C:\Users\HP\Desktop\a\materialize\js\materialize.js"></script>
<script type="text/javascript" src="C:\Users\HP\Desktop\a\jquery.min.js"></script>

        <form enctype="multipart/form-data" action="submit.php" method="POST" >
    
<br \>
<br \>	
<div class="input-field col s6">
          <i class="material-icons prefix">account_circle</i>
          <input id="usr" name="uname" type="text" placeholder="Name">
          <label for="usr"class="active">Name</label>
        </div>

	<div class="input-field col s6">
	<i class="material-icons prefix">mail_outline</i>
          <input id="emailid" name="useremail" type="email" placeholder="Email-id">
          <label for="emailid" class="active">Email-id</label>
		       
	</div>

        <div class="input-field col s6">
          <i class="material-icons prefix">phone</i>
          <input id="phno" name="phone" type="number"placeholder="Phone-No">
          <label for="phno"class="active">Phone-No</label>
        </div>
   
            <div class="input-field col s6">
		<i class="material-icons prefix">file_upload</i>
 		<input id="fil" name="userfile" type="file"  multiple="multiple">	
                    <label for="fil"></label>
		</div>

		<br \>
		
		
		<div class="input-field col s6">
		<button class="btn waves-effect waves-light">
    		<i class="material-icons right">send</i>
		 <span class="icm-padding"><input class="btn btn-success" type="submit" value="Submit"/></span>
  		</button>
		</div>
                     
    </form>

        </body>
</html>
