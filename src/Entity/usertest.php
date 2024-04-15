<?php 
 namespace Entity; 
 use Model\Database;
 require_once './src/model/Database.php';
 class usertest extends Database{ 

	 public function GET_SQL(){
	 $sql='CREATE TABLE IF NOT EXISTS usertest ( 
		 id INT AUTO_INCREMENT PRIMARY KEY
		firstname VARCHAR(255)  ,
		secondane VARCHAR(100)  null,
		age INT  null , 
		email VARCHAR(100)  ,
		 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)';
	 $statement = $this->conn->prepare($sql);$statement->execute();
	}
}$run = new usertest();
$run->GET_SQL();