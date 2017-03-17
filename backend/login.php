<?php
	
	include_once 'db_functions.php';
    $db = new DB_Functions();

    $inputJSON = file_get_contents('php://input');
	$data = json_decode($inputJSON, FALSE);

	$username = $data->{"username"};
	$password = $data->{"password"};

	$loginID = $db->login($username, $password);

	$arr = array();

	if($loginID) {
		$arr["status"] = "success";
		$jwt = $db->createToken($loginID);
		$data = array();
		$data["token"] = $jwt;
		$arr["data"] = $data;
	}
	else
		$arr["status"] = "failed";

	echo json_encode($arr);
	header('Content-Type: application/json');
	return;

?>