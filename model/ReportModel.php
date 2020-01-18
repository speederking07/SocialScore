<?php


class ReportModel
{
    private $conn;

    public function __construct(){
        $this->conn = new mysqli('localhost', 'root', '', 'SocialScore');
    }

    public function __destruct(){
        $this->conn->close();
    }

    public function getDeedsList()
    {
        $result = $this->conn->query("SELECT * FROM deed ORDER BY points DESC ");
        $res = [];
        if ($result->num_rows === 0) return $res;
        foreach ($result as $row) {
            array_push($res, ['id' => $row['id'], 'name' => $row['name'], 'points' => $row['points']]);
        }
        return $res;
    }

    public function sendReport($pesel, $deed, $desc)
    {
        $stmt = $this->conn->prepare("INSERT INTO report (id, date, PESEL, deed, description) VALUES (null, null, ?, ?, ?)");
        $stmt->bind_param("ssis", date('Y-m-d'), $pesel, $deed, $desc);
        $stmt->execute();
        $result = $stmt->affected_rows;
        return !($result == -1);
    }

    public function getDeed($id){
        $stmt = $this->conn->prepare("SELECT name, points FROM deed WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) return null;
        $row = $result->fetch_assoc();
        return ['name' => $row['name'], 'points' => $row['points']];
    }

    public function getPerson($pesel){
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
        return $res;
    }

    public function getReport()
    {
        $r = $this->conn->query("SELECT id, date, PESEL as pesel, deed, description AS 'desc'
            FROM report ORDER BY RAND() LIMIT 1");
        if($r->num_rows === 0) return null;
        $row = $r->fetch_assoc();
        print_r($row);
        return [
            'deed' => $this->getDeed($row['deed']),
            'person' => $this->getPerson($row['pesel']),
            'desc' => $row['desc'],
            'id' => $row['id'],
            'date' => $row['date'],
        ];
    }
}