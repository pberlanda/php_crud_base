<?php

require_once 'database.php'; // richiama la classe database.php

class User {
    private $conn;

    // Constructor
    public function __construct(){
      $database = new Database();
      $db = $database->dbConnection(); // richiama il metodo dbConnection dalla classe database.php
      $this->conn = $db;
    }


    // Execute queries SQL
    public function runQuery($sql){
      $stmt = $this->conn->prepare($sql); //stmt significa statement prepare() è prepared statement, vedi qui https://www.w3schools.com/php/php_mysql_prepared_statements.asp
      return $stmt;
    }

    // Insert (nuovo utente)
    public function insert($name, $email){
      try{
        $stmt = $this->conn->prepare("INSERT INTO crud_users (name, email) VALUES(:name, :email)"); // come vei qui si usa il prepared statement
        $stmt->bindparam(":name", $name);
        $stmt->bindparam(":email", $email);
        $stmt->execute();
        return $stmt;
      }catch(PDOException $e){
        echo $e->getMessage();
      }
    }


    // Update

    public function update($id, $name, $email){
      try{
        $stmt = $this->conn->prepare("UPDATE crud_users SET name = :name, name = :email WHERE id = :id");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt;
      } catch(PDOException $e){

      }
    }


    // Delete


    // Redirect URL method

}
?>
