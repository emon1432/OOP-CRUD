<?php

class Database
{
    private $db_host = "127.0.0.1";
    // private $db_host = "localhost";
    private $db_user = "root";
    private $db_password = "";
    private $db_name = "cse_25";
    private $mysqli = "";
    private $conn = false;
    private $result = array();

    //Create Connection
    public function __construct()
    {
        if (!$this->conn) {
            $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);
            $this->conn = true;
            if ($this->mysqli->connect_error) {
                array_push($this->result, $this->mysqli->connect_error);
                return false;
            }
        } else {
            return true;
        }
    }


    //Function to insert into database
    public function insert($table, $params = array())
    {
        //Check to see if the table exists
        if ($this->tableExists($table)) {
            // echo "<pre>";
            // print_r($params);
            // echo "</pre>";

            //conver array to string
            $table_columns = implode(', ', array_keys($params));
            $table_values = implode("', '", $params);

            $sql = "INSERT INTO $table ($table_columns) VALUES ('$table_values')";

            //Make the query to insert to the database
            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->insert_id);
                return true; // the data has been inserted
            } else {
                array_push($this->result, $this->mysqli->error);
                return false; // the data has not been inserted
            }
        } else {
            return false; //Table does not exist
        }
    }

    //Function to update row into database
    public function update($table, $params = array(), $where = null)
    {
        //Check to see if the table exists
        if ($this->tableExists($table)) {

            $args = array();
            foreach ($params as $key => $value) {
                $args[] = "$key = '$value'";
            }

            $sql = "UPDATE $table SET " . implode(', ', $args);
            if ($where != null) {
                $sql .= " WHERE $where";
            }
            //Make the query to updated to the database
            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->affected_rows);
                return true; // the data has been updated
            } else {
                array_push($this->result, $this->mysqli->error);
                return false; // the data has not been updated
            }
            
        } else {
            return false; //Table does not exist
        }
    }

    //Function to delete table or row(s) from database
    public function delete($table, $where = null)
    {
        //Check to see if the table exists
        if ($this->tableExists($table)) {
            $sql = "DELETE FROM $table";
            if($where!=null){
                $sql .= " WHERE $where";
            }

            //Make the query to updated to the database
            if ($this->mysqli->query($sql)) {
                array_push($this->result, $this->mysqli->affected_rows);
                return true; // the data has been deleted
            } else {
                array_push($this->result, $this->mysqli->error);
                return false; // the data has not been deleted
            }
            
        } else {
            return false; //Table does not exist
        }

    }

   

    //Function to SELECT from the database
    public function select($table,$columns="*",$join=null,$where=null,$order=null,$limit=null)
    {
        if ($this->tableExists($table)) {
            $sql = "SELECT $columns FROM $table";
            if($join!=null){
                $sql .= " JOIN $join";
            }
            if($where!=null){
                $sql .= " WHERE $where";
            }
            if($order!=null){
                $sql .= " ORDER BY $order";
            }
            if($limit!=null){
                $sql .= " LIMIT 0,$limit";
            }
        } else {
            return false; //Table does not exist
        }
        $this->get_sql($sql);
    }

     //Function to sql from the database
     public function get_sql($sql)
     {
         $query = $this->mysqli->query($sql);
         //Make the query to setect to the database
         if ($query) {
             $this->result = $query->fetch_all(MYSQLI_ASSOC);
             return true; //  data has been selected
         } else {
             array_push($this->result, $this->mysqli->error);
             return false; //  data has not been selected
         }
 
     }

    

    //Table Checking
    public function tableExists($table)
    {
        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
        $tableInDb = $this->mysqli->query($sql);
        if ($tableInDb) {
            if ($tableInDb->num_rows == 1) {
                return true;
            } else {
                array_push($this->result, $table . " does not exist in this Database");
                return false;
            }
        } else {
            array_push($this->result, " query failed!!!");
            return false;
        }
    }

    public function getResult()
    {
        $val = $this->result;
        $this->result = array();
        return $val;
    }


    //Close connection
    public function __destruct()
    {
        if ($this->conn) {
            if ($this->mysqli->close()) {
                $this->conn = false;
                return true;
            }
        } else {
            return false;
        }
    }
}
// $obj = new Database();
?>