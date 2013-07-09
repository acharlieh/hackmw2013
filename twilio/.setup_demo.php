<?php
if ($stmt = $mysqli->prepare("INSERT INTO phones (phone,user_id) VALUES (?,?)")) {
	$userId=1;
        $stmt->bind_param("sd", $_POST['From'],$userId);
        $stmt->execute();
        $stmt->close();
}
$mysqli->commit();
