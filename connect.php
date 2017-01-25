<?php

//Class to connect to SQL Database
//01    25/01/2017  Created     K Oates

class connect {

    protected $dbName = "siteLogin";
    protected $sqlUser = "Kieron";
    protected $sqlPass = "Admin";
    protected $host = "DESKTOP-VG3HOEJ";
    var $conn = null;

    function __construct() {
        
    }

    public function sqlConnection() {
        try {
        $this->conn = new PDO("sqlsrv:Server={$this->host}; Database={$this->dbName};", "{$this->sqlUser}", "{$this->sqlPass}");
        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
        return $this->conn;
        }
        catch(PDOException $e){
            echo 'unable to connect to database' . $e->getMessage();
            
        }
    }

    public function closeConn() {
        $this->conn = null;
    }

}

?>