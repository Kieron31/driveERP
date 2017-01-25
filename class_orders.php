<?php

//01    25/01/2017      K Oates
include_once ("connect.php");

class orders {

    var $sqlclass = null;
    var $result = null;
    var $orderID = null;
    var $sqlconn = null;

    function __construct() {
        $this->sqlclass = new connect();
        $this->sqlconn = $this->sqlclass->sqlConnection();
        $this->gotSQLConn();
    }

    public function getOrderItems($orderID) {
        //Get items from SQL to draw table
        $this->gotSQLConn();
        $sqlQuery = "SELECT OrderHeader.OrderID, OrderHeader.dueDate, OrderHeader.email, OrderHeader.telNo , OrderHeader.currency , OrderItems.quantity, OrderItems.price, Products.ProductCode, Products.ProductDescShort, OrderItems.quantity * OrderItems.price as itemValue
FROM            OrderHeader INNER JOIN
                         OrderItems ON OrderHeader.OrderID = OrderItems.OrderID INNER JOIN
                         Products ON OrderItems.ProductID = Products.ProductID 
 WHERE OrderItems.OrderID = $orderID ";
        $this->result = $this->sqlconn->prepare($sqlQuery);
        $this->result->execute();
        return $this->result;
    }

    private function gotSQLConn() {
        if ($this->sqlconn == null) {
            exit("ERROR:No SQL Connection - unale to continue");
        }
    }

}

class headers {

    var $teleNumber = null;
    var $dueDate = null;
    var $currency = null;
    var $custID = null;
    var $sqlclass = null;
    var $sqlconn = null;
    var $result = null;

    function __construct() {
        $this->sqlclass = new connect();
        $this->sqlconn = $this->sqlclass->sqlConnection();
    }

    public function getOrderHeaders($orderID) {
        $sqlQuery = "SELECT        CustomerID, dueDate, email, telNo, currency
FROM            OrderHeader WHERE OrderID = $orderID";
        $this->result = $this->sqlconn->prepare($sqlQuery);
        $this->result->execute();
        $rs = $this->result->fetchAll();
        return $rs;
    }

}
?>