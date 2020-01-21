<?php
class AuthModel
{
    private $conn;

    public function __construct(){
        $this->conn = new mysqli('localhost', 'BasicUser', 'VeryGoodBasicUserPassword123', 'SocialScore');
    }

    public function __destruct(){
        $this->conn->close();
    }

    public function login($login, $password){
        $salt = $this->getSaltByLogin($login);
        if(empty($salt)) return 'login';
        $hash = hash('md5', $password.$salt);
        $result = $this->conn->query("CALL auth('$login', '$hash')");
        $row = $result->fetch_assoc();
        if ($row['access'] == 0) return 'password';
        else return $row['access'];
    }

    public function getSaltByLogin($login){
        $stmt = $this->conn->prepare("SELECT salt FROM user WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) return null;
        $row = $result->fetch_assoc();
        return $row['salt'];
    }

    public function loginExist($login){
        return !empty($this->getSaltByLogin($login));
    }
}