<?php

class BlogManager
{

    /**
     * @var mysqli
     */
    private $db;


    public function __construct($dbConnection)
    {
        if ($dbConnection instanceof mysqli) {
            $this->db = $dbConnection;
        } else {
            throw new Exception('Connection injected should be of Mysqli object');
        }
    }


    /**
     * Get all posts with status 'published' from the database
     * @return array
     */
    public function findAllPublishedPosts()
    {
        $posts = [];
        $query = ""
            . "SELECT post.*, user.name as author "
            . "FROM post "
            . "LEFT JOIN user ON post.id_user = user.id "
            . "WHERE status > 0 "
            . "ORDER BY post.date_created DESC";
        $result = $this->db->query($query);
        if ($result) {
            // Cycle through results
            while ($row = $result->fetch_assoc()) {
                $posts[] = [
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'content' => $row['content'],
                    'author' => $row['author'],
                    'id_user' => $row['id_user'],
                    'date_created' => $row['date_created'],
                    'tags' => '' //$row['firstname']
                ];
            }
            // Free result set
            $result->close();
        } else {
            echo($this->db->error);
        }
        return $posts;
    }


    /**
     * Get one post by it's ID
     * @param Int $id
     * @return array
     */
    public function findOnePostById($id)
    {
        $query = ""
            . "SELECT post.*, user.name as author "
            . "FROM post "
            . "LEFT JOIN user ON post.id_user = user.id "
            . "WHERE post.id = '%s'";
        $query = sprintf($query, $this->db->real_escape_string($id));
        if ($result = $this->db->query($query)) {
            $row = $result->fetch_assoc();
            $post = [
                'id' => $row['id'],
                'title' => $row['title'],
                'content' => $row['content'],
                'author' => $row['author'],
                'date_created' => $row['date_created'],
                'comment' => $this->findAllCommentsByPostId($row['id']),
                'tags' => '' //$row['firstname']
            ];
            $result->close();
        } else {
            die($this->db->error);
        }
        return $post;
    }


    public function findAllCommentsByPostId($id)
    {
        $comments = [];
        $query = ""
            . "SELECT * "
            . "FROM comment "
            . "WHERE post_id = '%d'";
        $query = \sprintf($query, $this->db->real_escape_string($id));
        $result = $this->db->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = [
                    'id' => $row['id'],
                    'post_id' => $row['post_id'],
                    'content' => $row['content'],
                    'author' => $row['author'],
                    'author_url' => $row['author_url'],
                    'author_email' => $row['author_email'],
                    'date_created' => $row['date_created']
                ];
            }
            $result->close();
        } else
            die($this->db->error);
        return $comments;

    }


    public function addPost($title, $content, $userid)
    {
        $query = "INSERT INTO post (
              `title`, `content`, `status`, `id_user`, `date_created`
          )
          VALUES (
              '%s', '%s', 2, '%d', NOW()
          )";
        $query = \sprintf($query, $this->db->real_escape_string($title), $this->db->real_escape_string($content), $this->db->real_escape_string($userid));
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }


    public function addComment($name, $content, $post_id, $email = "", $url = "")
    {
        $query = "
            INSERT INTO comment (
                `post_id`, `content`, `author`, `author_email`, `author_url`, `date_created` 
            ) 
            VALUES ('%d', '%s', '%s', '%s', '%s', NOW())";
        $query = \sprintf($query, $this->db->real_escape_string($post_id),
            $this->db->real_escape_string($content),
            $this->db->real_escape_string($name),
            $this->db->real_escape_string($email),
            $this->db->real_escape_string($url));
//        echo $query; die();
        if ($result = $this->db->query($query)) {
            return true;
        } else {
            die($this->db->error);
        }
    }


}