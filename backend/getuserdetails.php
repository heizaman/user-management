<?php
	
	include_once 'db_functions.php';
    $db = new DB_Functions();

    $inputJSON = file_get_contents('php://input');
	$data = json_decode($inputJSON, FALSE);

	$token = $data->{"token"};

	$userId = $db->getUseridFromToken($token);

	$arr = array();

	if($userId) {
		$arr["status"] = "success";
		$data = array();
		$data["userid"] = $userId;
		$user = $db->findUserById($userId);
		$data["name"] = $user["name"];
		$data["username"] = $user["username"];
		$arr["data"] = $data;
	}
	else
		$arr["status"] = "failed";

	echo json_encode($arr);
	header('Content-Type: application/json');
	return;

?>