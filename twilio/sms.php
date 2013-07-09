<?php
require_once('.creds.php');

$from=$_POST['From'];
$statusCallback="http://hackmw.huggard.info/twilio/sms-callback.php";
$vals=array("Rock","Paper","Scissors","Lizard","Spock");
$idx=rand(0,count($vals)-1);

$mine=$vals[$idx];

$theirs=strtolower(trim($_POST['Body']));
$theirs=strtoupper($theirs[0]).substr($theirs,1);

if(!in_array($theirs,$vals,TRUE)) {
?>
<Response>
    <Sms statusCallback="<?=$statusCallback?>">I don't know "<?=$theirs?>"</Sms>
</Response>
<?php
 exit();
}

if($mine===$theirs) {
?>
<Response>
    <Sms statusCallback="<?=$statusCallback?>"><?=$mine?> -  It's a tie!</Sms>
</Response>
<?php
  exit();
}

$reasons = array_combine($vals,array(array(),array(),array(),array(),array()));
$reasons["Scissors"]["Paper"]="Scissors cut paper";
$reasons["Paper"]["Rock"]="Paper covers rock";
$reasons["Rock"]["Lizard"]="Rock crushes lizard";
$reasons["Lizard"]["Spock"]="Lizard poisons Spock";
$reasons["Spock"]["Scissors"]="Spock melts scissors";
$reasons["Scissors"]["Lizard"]="Scissors decapitate lizard";
$reasons["Lizard"]["Paper"]="Lizard eats paper";
$reasons["Paper"]["Spock"]="Paper disproves Spock";
$reasons["Spock"]["Rock"]="Spock vaporizes rock";
$reasons["Rock"]["Scissors"]="Rock breaks scissors";

$win=in_array($theirs,array_keys($reasons[$mine]));

$message = ($win)?"YES!":"DAMN!";

$reason = ($win)?$reasons[$mine][$theirs]:$reasons[$theirs][$mine];

?>
<Response>
    <Sms statusCallback="<?=$statusCallback?>"><?=$mine?>, <?=$message?> <?=$reason?></Sms>
</Response>
