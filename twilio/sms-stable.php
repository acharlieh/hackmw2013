<?php
require_once('.creds.php');

$from=$_POST['From'];
$statusCallback="http://hackmw.huggard.info/twilio/sms-callback.php";
$vals=array("Rock","Paper","Scissors","Lizard","Spock");
$idx=rand(0,count($vals)-1);
?>
<Response>
    <Sms statusCallback="<?=$statusCallback?>"><?=$vals[$idx]?></Sms>
</Response>
