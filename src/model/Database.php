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
    protected $conn;

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
            echo 'Base de données Enigma charger.\n';
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
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }
}