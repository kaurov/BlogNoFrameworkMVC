<?php

class DbConnectionManager
{

    private $connectionParam = [
        'host' => '',
        'port' => '',
        'user' => '',
        'password' => '',
        'dbname' => ''
    ];

    /**
     * @var mysqli
     */
    private $db;


    public function __construct($appConfig = null)
    {
        $this->connectionParam = $appConfig['connection']['params'];
        $this->db = $this->connect();

        if (\mysqli_connect_errno()) {
            \printf("Connect failed: %s\n", \mysqli_connect_error());
            if (\strpos(\mysqli_connect_error(), "Unknown database") !== NULL) {
                $this->install();
            }
            $this->db = $this->connect();
        }

        if (\mysqli_connect_errno()) {
            throw new \Exception(\sprintf("Connect failed: %s\n", \mysqli_connect_error()));
        }
    }


    private function connect()
    {
        $this->db = new \mysqli(
            $this->connectionParam['host'],
            $this->connectionParam['user'],
            $this->connectionParam['password'],
            $this->connectionParam['dbname']
        );
        return $this->db;
    }


    private function install()
    {
        $output = [];
        $conn = new \mysqli($this->connectionParam['host'], $this->connectionParam['user'], $this->connectionParam['password']);
        if ($conn->connect_error) {
            throw new \Exception("Connection failed: " . $conn->connect_error);
        }
        $sql = "CREATE DATABASE " . $this->connectionParam['dbname'];
        if ($conn->query($sql) === TRUE) {
            echo "Database created successfully";
        } else {
            $output[] = "<br />Error creating database: " . $conn->error;
        }



        $conn = $this->connect();
        $conn->store_result();
        $sql = \file_get_contents('../data/schema.mysql.sql');
        if (\mysqli_multi_query($conn, $sql)) {
            $output[] = "<br />SQL installation script is executed successfully";
        } else {
            throw new \Exception("Error of database setting up: " . $conn->error);
        }
        $conn->close();
    }


    public function getConnection()
    {
        return $this->db;
    }


}