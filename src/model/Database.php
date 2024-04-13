<?php

namespace Model;

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv as Dotenv;
use PDO;
use PDOException;
use Exception;

 abstract class Database
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $port;
    private $conn;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../../');
        $dotenv->load();
        
        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->port = $_ENV['DB_PORT'];
        $this->testConnection();
    }

    protected function testConnection()
    {
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';port=' . $this->port,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Information de la base de données correcte.\n";
            $this->createDatabase();
        } catch (PDOException $e) {
            var_dump($e);
        }
    }

    protected function createDatabase()
    {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS Enigma";
            $this->conn->exec($sql);
            echo 'Base de données Enigma créée.\n';
            $this->connect();
        } catch (PDOException $e) {
            var_dump('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    protected function connect()
    {
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';port=' . $this->port,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->insertTables();
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }

    protected function insertTables()
    {
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