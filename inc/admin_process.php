<?
error_reporting (E_ERROR | 0);

include_once('inc/config.php');

//use this for future register page      echo hash_hmac('sha256', $_POST['pass'], GLOBAL_SALT);

if(isset($_GET['log_out'])) {
	$Login_Process = new Login_Process;
	$Login_Process->log_out($_SESSION['username'], $_SESSION['password']); }	
	
class Login_Process {

	function connect_db() {
		$conn_str = mysql_connect(DBHOST, DBUSER, DBPASS);
		mysql_select_db(DBNAME, $conn_str) or die ('Could not select Database.');
	}

	function query($sql) {

		$this->connect_db();
		$sql = mysql_query($sql);
		$num_rows = mysql_num_rows($sql);
		$result = mysql_fetch_assoc($sql);
			
		return array("num_rows"=>$num_rows,"result"=>$result,"sql"=>$sql);
	
	}
	
	function check_status() {

		ini_set("session.gc_maxlifetime", Session_Lifetime); 
		session_start();
		
	}
		
	//LETS LOGIN
	function log_in($username, $password, $submit) {
		
		if(isset($submit)) {
		
		// HASH up the password
		$ENCpassword = hash_hmac('sha256', $password, GLOBAL_SALT);
		$query = $this->query("SELECT * FROM ".DBTBLE." WHERE username='$username' AND password='$ENCpassword'");

		if($query['num_rows'] == 1) {
			
				$this->set_session($username, $ENCpassword);					
							
		} else {
		
				return "<div class=\"error\"><img src=\"img/dialog_warning.png\"> Username or Password not recognised.</div>";
								
		}			
				
		} // eof if isset
	} // eof log_in
	
	function set_session($username, $ENCpassword) {
	
			$query = $this->query("SELECT * FROM ".DBTBLE." WHERE username='$username' AND password='$ENCpassword'");
	
			ini_set("session.gc_maxlifetime", Session_Lifetime); 
			session_start();

			$_SESSION['username']    = $query['result']['username'];
			$_SESSION['password']    = $query['result']['password'];
			$_SESSION['userid']      = $query['result']['row_id'];
			//add as many variables as you want here

	} //eof set_session
	
	
	function log_out($username, $password) {

	session_start();
	session_unset();
	session_destroy();    	
	header('Location: ../index.php');	//logout and send back to index		
	
	}
	

} // eof class Login_Process

?>
