<?php


class ProfileModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'Observer', 'MediocrateObserverPassword456', 'SocialScore');
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function getPeselByLogin($login)
    {
        $stmt = $this->conn->prepare("SELECT user.PESEL AS 'p' FROM user INNER JOIN person p on user.PESEL = p.PESEL WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) return null;
        $row = $result->fetch_assoc();
        return $row['p'];
    }

    public function getProfile($pesel)
    {
        $stmt = $this->conn->prepare("SELECT p.PESEL AS pesel, p.firstName AS first_name, p.lastName AS last_name, p.middleName AS middle_name,
            p.sex, p.birthdate, p.city, p.`e-mail` AS email,p.phone, p.socialScore AS 'points', p.photo,
            CONCAT(f.firstName, ' ', f.lastName) AS 'father', CONCAT(m.firstName, ' ', m.lastName) AS 'mother'
            FROM person p LEFT JOIN person f ON f.PESEL = p.fatherPESEL LEFT JOIN person m ON m.PESEL = p.motherPESEL WHERE p.PESEL = ?");
        $stmt->bind_param("s", $pesel);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) return null;
        $row = $result->fetch_assoc();
        $res = [];
        foreach ($row as $key => $val) {
            $res[$key] = $val;
        }
        $res['deeds'] = $this->getDeeds($pesel);
        $res['perks'] = $this->getPerks($res['points']);
        //print("<pre>".print_r($res,true)."</pre>");
        return $res;
    }

    private function getDeeds($pesel)
    {
        $stmt = $this->conn->prepare("SELECT name, date, points FROM persondeed INNER JOIN deed d on persondeed.deed = d.id WHERE person = ? ORDER BY date DESC");
        $stmt->bind_param("s", $pesel);
        $stmt->execute();
        $result = $stmt->get_result();
        $res = [];
        if ($result->num_rows === 0) return $res;
        foreach ($result as $row) {
            array_push($res, ['name' => $row['name'], 'date' => $row['date'], 'points' => $row['points']]);
        }
        return $res;
    }

    public function search($query)
    {
        $res = $this->conn->query("SELECT PESEL AS pesel, firstName AS first_name, lastName AS last_name, birthdate,
            socialScore AS points FROM person WHERE ".$this->searchString($query));
        $result = [];
        foreach ($res as $num => $row){
            foreach ($row as $key => $val){
                $result[$num][$key] = $val;
            }
        }
        return $result;
    }

    public function searchString($query)
    {
        $query = trim($query);
        do {
            $new = str_replace('  ', ' ', $query);
        }while($new != $query);
        $list = explode(' ', $query);
        $res = '';
        foreach ($list as $elem){
            if(is_numeric($elem)) $res .= "(birthdate LIKE '%$elem%' OR pesel LIKE '%$elem%' OR phone LIKE '%$elem%') AND";
            else{
                $elem = mysqli_real_escape_string($this->conn, $elem);
                $res .= "(firstName LIKE '%$elem%' OR middleName LIKE '%$elem%' OR lastName LIKE '%$elem%' OR city LIKE '%$elem%' OR sex = '$elem') AND";
            }
        }
        return substr($res, 0, strlen($res)-3);
    }

    public function getPerks($points)
    {
        $stmt = $this->conn->prepare("SELECT * FROM perk WHERE threshold < ? ORDER BY threshold DESC");
        $stmt->bind_param("i", $points);
        $stmt->execute();
        $result = $stmt->get_result();
        $res = [];
        if ($result->num_rows === 0) return $res;
        foreach ($result as $row) {
            array_push($res, ['name' => $row['name'], 'desc' => $row['description'], 'threshold' => $row['threshold']]);
        }
        return $res;
    }

    public function getNameByPesel($pesel)
    {
        $stmt = $this->conn->prepare("SELECT CONCAT(firstName, ' ', lastName) AS name FROM person WHERE PESEL = ?");
        $stmt->bind_param("s", $pesel);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) return 'Not found';
        $row = $result->fetch_assoc();
        return $row['name'];
    }
}