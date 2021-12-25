<?php 
    //pdo db class
    //connect to db
    //create prepraed stmnt
    //bind values
    //return rows and results

    class DATABASE
    {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $db_name = DB_NAME;

        private $dbh;
        private $stmt;
        private $error;

        public function __construct()
        {
            //Set DSN
            $dsn = 'mysql:host='.$this->host.';db_name='.$this->db_name;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            //CREATE PDO Instance
            try{
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            }
            catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }
         //Prepare statement with query
         public function query($sql)
         {
            //  if ($this->dbh == null)
            //     echo "77000007";
            // else
            // echo "11111";
            //  //echo $this->dbh;
            $this->stmt = $this->dbh->prepare($sql);
         }

         public function bind($param, $value, $type = null)
         {
             if(is_null($type))
             {
                 switch(true)
                 {
                     case  is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case  is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case  is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                 }

             }
             $this->stmt->bindValue($param,$value,$type);
         }
         //Execute the prepared statement
         public function execute()
         {
             return $this->stmt->execute();
         }
         //Get result set as array of objects
         public function resultSet()
         {
             /*if(!$this->execute());
                echo "AAAAAAAAAAAAAA";*/
                $this->execute();

             return $this->stmt->fetchAll(PDO::FETCH_OBJ);
         }
         //Get single record object
         public function single()
         {
             $this->execute();
             return $this->stmt->fetch(PDO::FETCH_OBJ);
         }
         // Get row count
         public function rowCount()
         {
             return $this->stmt->rowCount();
         }

    }
?>