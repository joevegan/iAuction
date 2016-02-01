<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/header.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secure Login: Log In</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
    <body>

    <br><br><br><br><br><br>
       
        <div id="ib2_loginWindow" style="width:20em; margin:0 auto;">

		<div class="panel panel-primary">
		  <div class="panel-heading">iAuction</div>
  			<div class="panel-body">
		        <?php
		        if (isset($_GET['error'])) {
		            echo '<p class="alert alert-danger">Error logging in, please try again.</p>';
		        }
		        ?> 
			<form action="includes/process_login.php" method="post" name="login_form" >
			
			<div class="input-group">
				<input type="text" name="email" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
				<input type="password" name="password" id="password"  class="form-control" placeholder="Password" aria-describedby="basic-addon1">
			</div>
			<br>
			<div style="display:inline-block;">
				<div class="btn-group" role="group" aria-label="..." style="float:left;">					
					<button type="button" value="Login" onclick="formhash(this.form, this.form.password);" class="btn btn-success">Log In</button>
					
				</div>
				<div class="btn-group" role="group" aria-label="..." style="margin-left:1em;">
					<button type="button" class="btn btn-primary disabled">Forgot?</button>	
					<a class="btn btn-warning" href='register.php'>Register</a>				
				</div>
			</div>
			
			
			</form>
			<?php
        if (login_check($mysqli) == true) {
                        echo '<p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';
 
            echo '<p>Do you want to change user? <a href="includes/logout.php">Log out</a>.</p>';
        } else {
                        echo '<p>Currently logged ' . $logged . '.</p>';
                        echo "<p>If you don't have a login, please register";
                }
?>      	</div>
		
		</div>
	
	</div>

    </body>
</html>