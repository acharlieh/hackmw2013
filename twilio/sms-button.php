<?php
require_once('.creds.php');

$from=$_POST['From'];
$statusCallback="http://hackmw.huggard.info/twilio/sms-callback.php";
$val=rand(1,3);
$response=($val===1)?'Button!':(($val===2)?'Boop!':'Rawr!!!!');
?>
<Response>
    <Sms statusCallback="<?=$statusCallback?>"><?=$response?></Sms>
</Response>
