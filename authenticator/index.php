<?php
require '../twilio/.totp.php';

$key='CUNR5CYFNMUV4LZL';

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
<head>
 <title>Twilio Google Authenticator</title>
</head>
<body>
<h1>1.) Download Google Authenticator and scan this:</h1>
<a href="<?=$qrurl?>"><img src="<?=$qrurl?>"/></a>
<h1>2.) Check that it's setup correctly with the below form</h1>
<form method="POST">
  <input type="text" id="test" name="test"/>
  <input type="submit"/>
</form>
<?php
if(isset($_POST['test'])) {
	$check = Google2FA::verify_key($key,$_POST['test']);
	if($check) {
		echo '<h1 style="color:green">Hurray!</h1>';
	} else {
		echo '<h1 style="color:red">Nope!</h1>';
	}
} 
?>
<h1>3.) Call +1 571-223-7637 to run through the script</h1>
<p>You will get a busy signal once, before being accepted.</p>
<a href="/">Back</a>
</body>
</html>
