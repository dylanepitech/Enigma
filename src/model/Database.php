<?php

namespace Model;

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv as Dotenv;
use PDO;

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

        $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname";
        
        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\Throwable $th) {
           echo "$th";
        }
       
    }

   abstract public function GET_CONNECTION();

}