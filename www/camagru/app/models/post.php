<?php 
    class Post
    {
        private $db;
        public function __construct()
        {
            $this->db = new Database;
        }
        public function getPosts()
        {
            $this->db->query('SELECT *,
                camagru.posts.id as postId,
                camagru.users.id as userId,
                posts.created_at as postCreated,
                users.created_at as userCreated
                From camagru.posts
                INNER JOIN camagru.users
                ON camagru.posts.user_id = camagru.users.id
                ORDER BY camagru.posts.created_at DESC');
            $results = $this->db->resultSet();
            return $results;

        }
        public function addPost($data)
        {
            $this->db->query('INSERT INTO camagru.posts (title,body,user_id) VALUES(:title,:body,:user_id)');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':user_id', $data['user_id']);
            if ($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function getPostById($id)
        {
            $this->db->query('SELECT * From camagru.posts WHERE id = :id');
            $this->db->bind(':id',$id);
            $post = $this->db->single();
            return $post;

        }

        public function updatePost($data)
        {
            $this->db->query('UPDATE camagru.posts  SET title = :title , body = :body  WHERE id = :id');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':id', $data['id']);
            if ($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function deletePost($id)
        {
            $this->db->query('DELETE  FROM camagru.posts WHERE id =:id ');
            $this->db->bind(':id', $id);
            if ($this->db->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }



?>