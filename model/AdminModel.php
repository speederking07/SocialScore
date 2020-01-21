<?php


class AdminModel
{
    private $conn;

    public function __construct(){
        $this->conn = new mysqli('localhost', 'GodMode', 'AwfulGodModePasswordWeShouldChangeIt', 'SocialScore');
    }

    public function __destruct(){
        $this->conn->close();
    }

    public function sustainReport($id)
    {
        $stmt = $this->conn->prepare("CALL acceptReport(?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        return !($result == -1);
    }

    public function overruleReport($id)
    {
        $stmt = $this->conn->prepare("CALL dismissReport(?)");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->affected_rows;
        return !($result == -1);
    }

    public function addPerson($pesel, $mother, $father ,$firstName, $middleName, $lastName, $city, $email, $phone, $photo){
        if(!is_numeric($pesel)) return false;
        if(!empty($mother)) $mother = mysqli_real_escape_string($this->conn, $mother);
        else $mother = 'null';
        if(!empty($father)) $father = mysqli_real_escape_string($this->conn, $father);
        else $father = 'null';
        if(!empty($firstName)) $firstName = "'".mysqli_real_escape_string($this->conn, $firstName)."'";
        else return false;
        if(!empty($lastName)) $lastName = "'".mysqli_real_escape_string($this->conn, $lastName)."'";
        else return false;
        if(!empty($middleName)) $middleName = "'".mysqli_real_escape_string($this->conn, $middleName)."'";
        else $middleName = 'null';
        if(!empty($city)) $city = "'".mysqli_real_escape_string($this->conn, $city)."'";
        else $city = 'null';
        if(!empty($email)) $email = "'".mysqli_real_escape_string($this->conn, $email)."'";
        else $email = 'null';
        if(!empty($phone)) $phone = "'".mysqli_real_escape_string($this->conn, $phone)."'";
        else $phone = 'null';
        if(!empty($photo)) $photo = "'".mysqli_real_escape_string($this->conn, $photo)."'";
        else $photo = 'null';
        $query = "INSERT INTO person
        (PESEL, firstName, lastName, middleName, sex, birthdate, city, `e-mail`, phone,
            fatherPESEL, motherPESEL, socialScore, photo) VALUES
            ($pesel,$firstName,$lastName,$middleName, null, null,$city,$email,$phone,$father,$mother,0,$photo)";
        //print_r($query);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->affected_rows;
        return !($result == -1);
    }

    public function addAccount($login, $password, $pesel, $access){
        $stmt = $this->conn->prepare("INSERT INTO user (login, password, salt, PESEL, access) VALUES (?, ?, ?, ?, ?)");
        $salt = $this->randString(12);
        $hash = hash('md5', $password.$salt);
        $stmt->bind_param("ssssi", $login, $hash, $salt, $pesel, $access);
        $stmt->execute();
        $result = $stmt->affected_rows;
        return !($result == -1);
    }

    private function randString($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}