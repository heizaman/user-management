<?php
	
	include_once 'db_functions.php';
    $db = new DB_Functions();

    $inputJSON = file_get_contents('php://input');
	$data = json_decode($inputJSON, FALSE);

	$arr = array();

	$name = trim($data->{"name"});
	$username = trim($data->{"username"});
	$password = trim($data->{"password"});

	if($name == "" || $username == "" || $password == "") {
		$arr["status"] = "failed";
		echo json_encode($arr);
		header('Content-Type: application/json');
		return;
	}

	$register = $db->registerUser($name, $username, $password);

	if($register)
		$arr["status"] = "success";
	else
		$arr["status"] = "failed";

	echo json_encode($arr);
	header('Content-Type: application/json');
	return;

?>