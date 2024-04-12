<?php
namespace Model;
require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv as Dotenv;
use PDO;
use PDOException;
use Exception;
use mysqli;

class Database
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
        // $this->connect();
    }
    protected function TEST_CONNECTION()
    {
        try{
            $this->conn = new mysqli($this->host, $this->username, $this->password);

            if ($this->conn)
            {
                $this->CREATE_TABLE();
            }
        }catch (PDOException $e)
        {
            var_dump($e);
        }
    }

    protected function CREATE_TABLE()
    {
        if ($this->conn) {
        $sql = "CREATE DATABASE Enigma";
        if ($this->conn->query($sql) == true) {
            $this->CONNECT();
        } else {
            var_dump('Error creating database: ');
        }
    } else {
        var_dump('Error establishing database connection.');
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
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de donnée: " . $e->getMessage());
        }
    }

}

$test = new Database();