<?php
require '.totp.php';

if(!isset($_REQUEST['key'])) {
  $key=Base32::encode(openssl_random_pseudo_bytes(10));
} else {
  $key=$_REQUEST['key'];
}

$encodedKey=urlencode($key);
$params = http_build_query(
	array('chs'=>'200x200',
		'chld'=>'M|0', //??? H|0 
		'cht'=>'qr',
		'chl'=>"otpauth://totp/hackmw.huggard.info?secret=${encodedKey}"
));
$qrurl = "http://chart.apis.google.com/chart?${params}";
?>
<html>
<body>
<a href="<?=$qrurl?>"><img src="<?=$qrurl?>"/></a>
<br/>
<?
if(isset($_POST['test'])) {
	$check = Google2FA::verify_key($key,$_POST['test']);
	if($check) {
		echo '<h1 style="color:green">Hurray!</h1>';
	} else {
		echo '<h1 style="color:red">Nope!</h1>';
	}
}
?>
<form method="POST">
  <label for="test"><?=$key?></label><br/> 
  <input type="hidden" id="key" name="key" value="<?=$key?>"/>
  <input type="text" id="test" name="test"/>
  <input type="submit"/>
</form>
</body>
</html>
