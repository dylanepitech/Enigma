<?php 
namespace Model;

use PDOException;

class Method extends Database
{
    public function __construct() {
        $userQuery = "CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(255),
            lastname VARCHAR(255),
            pseudo VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            phone VARCHAR(20),
            birthdate DATE,
            postcode VARCHAR(10),
            zipcode VARCHAR(10),
            password VARCHAR(255),
            secret_code VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $tokenQuery = "CREATE TABLE IF NOT EXISTS token (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_user INT,
            FOREIGN KEY (id_user) REFERENCES user(id)
        )";

        try {
            $this->conn->exec($userQuery);
            echo "Table user créée";
        } catch (PDOException $e) {
            var_dump("Erreur lors de la création de la table user : " . $e->getMessage());
        }

        try {
            $this->conn->exec($tokenQuery);
            echo "Table token créée";
        } catch (PDOException $e) {
            var_dump("Erreur lors de la création de la table token : " . $e->getMessage());
        }
    }
}
$implement = new Method();