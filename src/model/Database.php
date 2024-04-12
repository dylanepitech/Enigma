<?php
namespace Model;
require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv as Dotenv;
use PDO;
use PDOException;
use Exception;
use mysqli;

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
        $this->TEST_CONNECTION();
    }
    protected function TEST_CONNECTION()
    {
        try{
            $this->conn = new mysqli($this->host, $this->username, $this->password);

            if ($this->conn)
            {
                $this->CREATE_DATABASE();
                echo "Information de la base de donnée correct.";
            }
        }catch (PDOException $e)
        {
            var_dump($e);
        }
    }

    protected function CREATE_DATABASE()
    {
        if ($this->conn) {
        $sql = "CREATE DATABASE Enigma";
        if ($this->conn->query($sql) == true) {
            $this->CONNECT();
            echo 'Base de donnée Enigma Créé.';
        } else {
            var_dump('Erreur de connection à la base de donnée');
        }
    } else {
        var_dump("Impossible d'établir une connection avec la base de donnée");
    }
    
    }

    protected function CONNECT()
    {
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';port=' . $this->port,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->INSERT_TABLE();
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de donnée: " . $e->getMessage());
        }
    }

    protected function INSERT_TABLE()
    {
        $User = "CREATE TABLE user (
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
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";

        $Token = 'CREATE TABLE token (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_user INT,
            FOREIGN KEY (id_user) REFERENCES user(id)';

            try {
               $statement = $this->conn->prepare($User);
               $statement->execute();
               
            }catch(PDOException){
                var_dump("Erreur l'or de la création de la table user");
            }

            try {
                $statement = $this->conn->prepare($Token);
                $statement->execute();
                
             }catch(PDOException){
                 var_dump("Erreur l'or de la création de la table user");
             }
        
    }
};