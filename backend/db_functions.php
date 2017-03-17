<?php

class DB_Functions {

    private $db;
    private $con;

    function __construct() {
        include_once './db_connect.php';
        require_once './config.php';
        require_once('./JWT.php');
        $this->db = new DB_Connect();
        $this->con = $this->db->connect();
    }


    function __destruct() {
    }

    /*public function storeUser($User) {
        $result = mysql_query("INSERT INTO user(Name) VALUES('$User')");		
        if ($result) {
			return true;
        } else {
			return false;
		}
    }

    public function getAllUsers() {
        $result = mysql_query("select * FROM user");
        return $result;
    }

    public function getUnSyncRowCount() {
        $result = mysql_query("SELECT * FROM user WHERE syncsts = FALSE");
        return $result;
    }
	
	public function updateSyncSts($id, $sts){
		$result = mysql_query("UPDATE user SET syncsts = $sts WHERE Id = $id");
		return $result;
	}*/


    public function findUserByUsername($username) {
        $username = mysqli_real_escape_string($this->con, $username);
        $result = mysqli_query($this->con, "SELECT * FROM users WHERE username = '$username'");
        return $result;
    }


    public function findUserById($id) {
        $result = mysqli_query($this->con, "SELECT * FROM users WHERE id = $id");
        if(mysqli_num_rows($result) == 0)
            return false;
        $user = mysqli_fetch_array($result);
        return $user;
    }


    public function registerUser($name, $username, $password) {
        $userNum = mysqli_num_rows($this->findUserByUsername($username));
        //var_dump($userNum);
        if($userNum > 0) {
            return false;
        }
        
        $name = mysqli_real_escape_string($this->con, $name);
        $username = mysqli_real_escape_string($this->con, $username);
        $password = mysqli_real_escape_string($this->con, $password);
        $result = mysqli_query($this->con, "INSERT INTO users (id, name, username, password) VALUES (DEFAULT, '$name', '$username', '$password')");
        return $result;
    }


    public function login($username, $password) {
        $result = $this->findUserByUsername($username);
        $userNum = mysqli_num_rows($result);

        if($userNum == 0) {
            return false;
        }

        $user = mysqli_fetch_array($result);

        if($password != $user["password"]) {
            return false;
        }

        return $user["id"];
    }


    public function createToken($id) {
        $payload = array(
            "id" => $id,
            "t" => time()
        );
        $jwt = JWT::encode($payload, JWT_KEY);

        return $jwt;
    }

    public function getUseridFromToken($token) {
        try {
            $decoded = JWT::decode($token, JWT_KEY, array('HS256'));
            return $decoded->id;
        } catch(Exception $exp) {
            return false;
        }
    }


 /*   public function newUserData($name, $isd, $phone, $email, $dob, $city) {
        $name = mysql_real_escape_string($name);
        $phone = mysql_real_escape_string($phone);
        $email = mysql_real_escape_string($email);
        $dob = mysql_real_escape_string($dob);
        $city = mysql_real_escape_string($city);

        $time = time();
        $token = $time;
        $result = mysql_query("UPDATE users SET name='$name', email='$email', dob='$dob', city='$city', token='$token' WHERE phone='$phone'");
        if($result) {
            $resultb = mysql_query("SELECT id FROM users WHERE phone='$phone' LIMIT 1");
            if($resultb) {
                $no = mysql_num_rows($resultb);
                if($no) {
                    $user = mysql_fetch_array($resultb);
                    $a = array();
                    $a["status"] = "Success";
                    $a["uid"] = $user["id"];
                    $a["utoken"] = $token;
                    $a["time"] = $time;
                    return $a;
                }
            }
        }
    }
*/
}
 
?>
