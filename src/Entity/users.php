<?php 
 namespace Entity; 
 use Model\Database;
 require_once './src/model/Database.php';
 class users extends Database{ 

	 public function GET_SQL(){
	 $sql='CREATE TABLE IF NOT EXISTS users ( 
		 id INT AUTO_INCREMENT PRIMARY KEY,
		firstname VARCHAR(255)  ,
		lastname VARCHAR(255)  ,
		email VARCHAR(255)  ,
		age INT   , 
		 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)';
	 $statement = $this->conn->prepare($sql);$statement->execute();
	}
}
$run = new users();
$run->GET_SQL();
