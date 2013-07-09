<?php
require "/usr/share/php/Services/Twilio.php";

class appmysql extends mysqli {
    public function __construct() {
        parent::__construct('localhost', 'root', 'hackmw', 'twilio');
	if($this->connect_error) {
		die("Connect Error ({$this->connect_errno}) {$this->connect_error}");
	}
    }
}

function logit() {
	$data=$_POST;
	$data['_timestamp']=date('c');
	file_put_contents ( '/twilio/postlog.json', json_encode( $data )."\n",FILE_APPEND);
}

$mysqli = new appmysql();

function doClose(&$mysqli) {
	$mysqli->close();
}

register_shutdown_function("logit");
register_shutdown_function("doClose",$mysqli);

header('Content-Type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
