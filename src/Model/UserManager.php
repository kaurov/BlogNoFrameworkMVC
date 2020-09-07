<?php

class UserManager
{

    /**
     * @var mysqli
     */
    private $db;


    public function __construct($dbConnection)
    {
        if ($dbConnection instanceof \mysqli) {
            $this->db = $dbConnection;
        } else {
            throw new \Exception('Connection injected should be of Mysqli object');
        }
        \session_start();
    }


    /**
     * Auth user
     * @param String $email
     * @param String $password
     * @return boolean
     */
    public function login($email, $password)
    {
        $user = $this->findOneUserById($email, $password);
        if ($user) {
            $_SESSION['adminid'] = $user['id'];
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get user by it's credentials
     * @param Srting $email
     * @param Srting $password
     * @return array
     */
    public function findOneUserById($email, $password)
    {
        $query = ""
            . "SELECT user.* "
            . "FROM user "
            . "WHERE user.email = '%s' AND user.password = '%s'";
        $query = \sprintf($query, $this->db->real_escape_string($email), $this->getHash($password));
        if ($result = $this->db->query($query)) {
            $row = $result->fetch_assoc();
            if (!$row) {
                return false;
            }
            $user = [
                'id' => $row['id'],
                'email' => $row['email'],
                'name' => $row['name']
            ];
            $result->close();
        } else {
            die($this->db->error);
        }
        return $user;
    }


    /**
     * Logout user
     * @return boolean
     */
    public function logout()
    {
        unset($_SESSION['adminid']);
        return true;
    }


    /**
     * Check if user is already logined
     * @return Integer id or false
     */
    public function isLoggedIn()
    {
        if (isset($_SESSION['adminid']) && $_SESSION['adminid']) return $_SESSION['adminid'];
        return false;
    }


    private function getHash($password)
    {
        return \hash('sha512', $this->db->real_escape_string($password));
    }

}