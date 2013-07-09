<?php

if ($stmt = $mysqli->prepare("SELECT u.key,u.id FROM phones p join users u on p.user_id=u.id WHERE p.phone=?")) {
        $stmt->bind_param("s", $_POST['From']);
	$stmt->execute();
        $stmt->bind_result($key,$userId);
        $stmt->fetch();
        $stmt->close();
}

if(!isset($_SESSION['user_id'])) {
//Not previously authenticated
	if(!isset($key)) {
	//Unknown to the system => Reject Call & Destroy Session
	//We set it to busy, otherwise google voice rings and rings and rings...
		echo '<Response><Reject reason="busy"/></Response>';
		require ".setup_demo.php";
		killSession();
		exit();
	}
	//Attempted to authenticate
	$attemptNbr = (isset($_SESSION["authAttempt"]))?$_SESSION["authAttempt"]+1:0;
	
	$attempted = isset($_POST['Digits']);

	if($attempted) {
		require_once '.totp.php';
		$guess=$_POST['Digits'];
		//TODO: ensure 6 digits, all numeric
		$passed=Google2FA::verify_key($key,$guess);
	} else {
		$passed=false;
	}

	if(!$passed) {
		echo "<Response>";
		if($attemptNbr > 0) {
			echo "<Say>That is not correct.</Say>";
		}
		if($attemptNbr < 3) {
?>
  <Gather timeout="5" finishOnKey="*" numDigits="6">
    <Say>Please enter your current One-Time Password</Say>
  </Gather>
  <Redirect/>
<?php
		} else {
?>
  <Say>I'm sorry, you are required to provide a valid one time password</Say>
  <Say>The KGB are on their way.</Say>
  <Say>Have a nice day!</Say>
  <Hangup/>
<?	
		}
		echo "</Response>";
		$_SESSION["authAttempt"]=$attemptNbr;
		exit();
	}

	//Sucessful authentication for the first time.	
	unset($_SESSION["authAttempt"]);
	$_SESSION['user_id']=$userId;
} else {
   //Previously Authenticated but no longer
   if(!isset($key)||!$_SESSION['user_id']===$userId) {
?>
<Response>
  <Say>I'm sorry, your access has been revoked.</Say>
  <Say>The NSA is on their way.</Say>
  <Say>Have a nice day!</Say>
  <Hangup/>
</Response>
<?php
	exit();
   }
}
//Success!
