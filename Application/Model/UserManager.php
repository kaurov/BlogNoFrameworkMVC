<?php

class UserManager
{

    private $connectionParam = [
        'host' => '',
        'port' => '',
        'user' => '',
        'password' => '',
        'dbname' => ''
    ];
    private $db;

    public function __construct($appConfig = null)
    {
        session_start();
        
        $this->connectionParam = $appConfig['connection']['params'];
        $this->db = new mysqli($this->connectionParam['host'], $this->connectionParam['user'], $this->connectionParam['password'], $this->connectionParam['dbname']);
        
        
        if (mysqli_connect_errno())
        {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
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
        $user = array();
        $query = ""
                . "SELECT user.* "
                . "FROM user "
                . "WHERE user.email = '%s' AND user.password = '%s'";
        $query = sprintf($query, $this->db->real_escape_string($email),  md5($this->db->real_escape_string($password)));
        if ($result = $this->db->query($query))
        {
            $row = $result->fetch_assoc();
            if (!$row) return false;
            $user = array(
                'id' => $row['id'],
                'email' => $row['email'],
                'name' => $row['name']
            );
            $result->close();
        } else
            die($this->db->error);
        return $user;
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
        if ($user)
        {
            $_SESSION['adminid'] = $user['id'];
            return true;
        } else
        {
            return false;
        }
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
    public function is_logined()
    {
        if (isset($_SESSION['adminid']) && $_SESSION['adminid']) return $_SESSION['adminid'];
        return false;
    }

}
