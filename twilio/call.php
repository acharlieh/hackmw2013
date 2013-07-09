<?php
require_once('.creds.php');
require_once('.session.php');
startSession();

require('.checkkey.php');

?>
<Response>
  <Say>Greetings Professor Falken</Say>
  <Say>HOW ARE YOU FEELING TODAY?</Say>
  <Record timeout="5" maxLength="5" action="call2.php" />
</Response>
