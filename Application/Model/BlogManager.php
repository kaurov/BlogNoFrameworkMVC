<?php

class BlogManager
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
        $this->connectionParam = $appConfig['connection']['params'];
        
        
        $this->db = new mysqli($this->connectionParam['host'], $this->connectionParam['user'], $this->connectionParam['password'], $this->connectionParam['dbname']);
        
        
        if (mysqli_connect_errno())
        {
            printf("Connect failed: %s\n", mysqli_connect_error());
            if (strpos(mysqli_connect_error(), "Unknown database") !== NULL)
            {
                $this->install();
            }
            exit();
        }
    }
    
    private function install()
    {
        $conn = new mysqli($this->connectionParam['host'], $this->connectionParam['user'], $this->connectionParam['password']);
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "CREATE DATABASE " . $this->connectionParam['dbname'];
        if ($conn->query($sql) === TRUE)
        {
            echo "Database created successfully";
            $sql = file_get_contents('../data/schema.mysql.sql');
            if (mysqli_multi_query($conn, $sql))
            {
                echo "Database installed successfully";
            } else
            {
                echo "Error installing database: " . $conn->error;
            }
        } else
        {
            echo "Error creating database: " . $conn->error;
        }
        $conn->close();
    }
    

    /**
     * Get all posts with status 'published' from the database
     * @return array
     */
    public function findAllPublishedPosts()
    {
        $posts = array();
        $result = $this->db->query("SELECT * FROM post WHERE status > 0");
        $query = ""
                . "SELECT post.*, user.name as author "
                . "FROM post "
                . "LEFT JOIN user ON post.id_user = user.id "
                . "WHERE status > 0 "
                . "ORDER BY post.date_created DESC";
        //$query = sprintf($query, $this->db->real_escape_string($id));
        if ($result)
        {
            // Cycle through results
            while ($row = $result->fetch_assoc()) {
                $posts[] = array(
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'content' => $row['content'],
                    'author' => $row['id_user'],
                    'date_created' => $row['date_created'],
                    'tags' => '' //$row['firstname']
                );
            }
            // Free result set
            $result->close();
        } else
            echo($this->db->error);

        return $posts;
    }

    /**
     * Get one post by it's ID
     * @param Int $id
     * @return array
     */
    public function findOnePostById($id)
    {
        $post = array();
        $query = ""
                . "SELECT post.*, user.name as author "
                . "FROM post "
                . "LEFT JOIN user ON post.id_user = user.id "
                . "WHERE post.id = '%s'";
        $query = sprintf($query, $this->db->real_escape_string($id));
        if ($result = $this->db->query($query))
        {
            $row = $result->fetch_assoc();
            $post = array(
                'id' => $row['id'],
                'title' => $row['title'],
                'content' => $row['content'],
                'author' => $row['author'],
                'date_created' => $row['date_created'],
                'comment' => $this->findAllCommentsByPostId($row['id']),
                'tags' => '' //$row['firstname']
            );

            $result->close();
        } else
            die($this->db->error);
        return $post;
    }
    
    
    public function findAllCommentsByPostId($id)
    {
        $comments = array();
        $query = ""
                . "SELECT * "
                . "FROM comment "
                . "WHERE post_id = '%d'";
        $query = sprintf($query, $this->db->real_escape_string($id));
        $result = $this->db->query($query);
        if ($result)
        {
            while ($row = $result->fetch_assoc()) {
                $comments[] = array(
                    'id' => $row['id'],
                    'post_id' => $row['post_id'],
                    'content' => $row['content'],
                    'author' => $row['author'],
                    'author_url' => $row['author_url'],
                    'author_email' => $row['author_email'],
                    'date_created' => $row['date_created']
                );
            }
            $result->close();
        }               
        else
            die($this->db->error);
        return $comments;
        
    }
    
    
    public function addPost($title, $content, $userid)
    {
        $query =  "INSERT INTO post(`title`, `content`, `status`, id_user) "
                . "VALUES ( '%s', '%s', 2, '%d')";
        $query = sprintf($query, $this->db->real_escape_string($title),  $this->db->real_escape_string($content),  $this->db->real_escape_string($userid) );
        if ($result = $this->db->query($query))
        {
            return true;
        } else
            die($this->db->error);
    }
    
    
    
    public function addComment($name, $content, $post_id, $email="", $url="")
    {
        $query =  "INSERT INTO comment
                            (`post_id`, `content`, `author`, `author_email`, `author_url`) "
                . "VALUES   ('%d', '%s', '%s', '%s', '%s')";
        $query = sprintf($query, $this->db->real_escape_string($post_id), 
                                $this->db->real_escape_string($content),  
                                $this->db->real_escape_string($name),  
                                $this->db->real_escape_string($email),  
                                $this->db->real_escape_string($url) );
        if ($result = $this->db->query($query))
        {
            return true;
        } else
            die($this->db->error);
    }
    
    


}
