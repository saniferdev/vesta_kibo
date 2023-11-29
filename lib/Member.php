<?php
namespace Phppot;

class Member
{

    private $ds;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    public function getMember($username)
    {
        $query = 'SELECT * FROM tbl_member where username = ?';
        $paramType = 's';
        $paramValue = array(
            $username
        );
        $memberRecord = $this->ds->select($query, $paramType, $paramValue);
        return $memberRecord;
    }

    public function loginMember()
    {
        $memberRecord = $this->getMember($_POST["username"]);
        $loginPassword = 0;
        if (!empty($memberRecord)) {
            if (!empty($_POST["password"])) {
                $password = $_POST["password"];
            }
            $hashedPassword = $memberRecord[0]["password"];
            $loginPassword = 0;
            if ( md5($password) == $hashedPassword ) {
                $loginPassword = 1;
            }
        } else {
            $loginPassword = 0;
        }
        if ($loginPassword == 1) {
            session_start();
            $_SESSION["username"]   = $memberRecord[0]["username"];
            $_SESSION["site"]       = $memberRecord[0]["site"];
            $_SESSION["type"]       = $memberRecord[0]["type"];
            $_SESSION["groupe"]     = $memberRecord[0]["groupe"];
            session_write_close();
            $url = "sortie.php";
            header("Location: $url");
        } else if ($loginPassword == 0) {
            $loginStatus = "Erreur d'authentification.";
            return $loginStatus;
        }
    }
}