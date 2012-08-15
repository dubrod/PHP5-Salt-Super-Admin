<?
include_once('inc/admin_process.php');    
$Login_Process = new Login_Process;
$Login_Process->check_status($_SERVER['SCRIPT_NAME']);
$Login = $Login_Process->log_in($_POST['user'], $_POST['pass'], $_POST['submit']);

?>
<!doctype html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Super Salt Admin</title>
    <link rel="stylesheet" type="text/css" href="admin-styles.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript">
    $(document).ready(function() {
    jQuery('form#loginForm').find('input').focus(function() {
                if (this.value == this.defaultValue){ 
                    this.value = '';
                }
                if(this.value != this.defaultValue){
                    this.select();
                }
            });
            jQuery('form#loginForm').find('input').blur(function() {
                if (jQuery.trim(this.value) == ''){
                    this.value = (this.defaultValue ? this.defaultValue : '');
                }
            });
    });
    </script>    
</head>
<body>

<?php 

if(isset($_SESSION['username'])) {
	//yes you are logged and session is set. now you can do whatever you want. 
	echo "<p style=\"color:#FFF;\">Hey! ".$_SESSION['username'].", Your already Logged in!</p>";
	echo "<p style=\"color:red;\"><a href=\"inc/admin_process.php?log_out=true\" class=\"logout\">LOGOUT</a></p>";
	
	} else {	

?>

<?php echo $Login; // if error ?>

<div id="box">
<form method="post" id="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<h1>SUPER SALT ADMIN</h1>
<label id="username">username</label><input name="user" type="text" class="field" id="user" value="username" /> 
<br />
<label id="password">password</label><input name="pass" type="password" class="field" id="pass" value="***********" />
<br>
<button name="submit" type="submit">Log In</button>
</form>
</div>
<? } ?>

</body>
</html>
