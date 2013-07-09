<?php
require_once('.creds.php');
require_once('.session.php');
startSession();

require('.checkkey.php');

if ($stmt = $mysqli->prepare("DELETE FROM phones WHERE phone=?")) {
        $stmt->bind_param("s", $_POST['From']);
        $stmt->execute();
        $stmt->close();
	$mysqli->commit();
}

?>
<Response>
  <Say>Excellent.</Say>
  <Say>It's been a long time.</Say>
  <Say>Can you explain the removal of your user account on June 23rd 1972?</Say>
  <Pause length="5"/>
  <Say>Would you like to play a game?</Say>
  <Pause length="5"/>
  <Redirect>call3.php</Redirect>
</Response>
