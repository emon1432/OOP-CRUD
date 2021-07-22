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
        if(!$this->conn){
            $this->mysqli = new mysqli($this->db_host,$this->db_user,$this->db_password,$this->db_name);
            $this->conn=true;
            if($this->mysqli->connect_error){
                array_push($this->result,$this->mysqli->connect_error);
                return false;
            }
        }
        else{
            return true; 
        }
    }


    //Function to insert into database
    public function insert($table, $params=array())
    {
        if($this->tableExists($table)){
            // echo "<pre>";
            // print_r($params);
            // echo "</pre>";

            $table_columns = implode(', ',array_keys($params));
            $table_values = implode("', '",$params);

            $sql = "INSERT INTO $table ($table_columns) VALUES ('$table_values')";
            
            if($this->mysqli->query($sql)){
                array_push($this->result,$this->mysqli->insert_id);
                return true;
            }else{
                array_push($this->result, $this->mysqli->error);
            }
        }else{
            return false;
        }
    }

    //Function to update row into database
    public function update()
    {
    }

    //Function to delete table or row(s) from database
    public function delete()
    {
    }

    //Function to SELECT from the database
    public function select()
    {
    }

    //Table Checking
    public function tableExists($table){
        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
        $tableInDb = $this->mysqli->query($sql);
        if($tableInDb){
            if($tableInDb->num_rows==1){
                return true;
            }else{
                array_push($this->result, $table." does not exist in this Database");
                return false;
            }
        }else{
            array_push($this->result," query failed!!!");
            return false;
        }
    }

    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }


    //Close connection
    public function __destruct()
    {
        if($this->conn){
            if($this->mysqli->close()){
                $this->conn = false;
                return true;
            }
        }else{
            return false;
        }
    }
}
// $obj = new Database();
?>
