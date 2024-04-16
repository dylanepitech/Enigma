<?php 
namespace Model;
require_once './src/model/Database.php';

class Method extends Database
{
    public function GET_CONNECTION()
    {
        return $this->conn;
    }

    public function CREATE_DB()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS Enigma';
        $statement = self::GET_CONNECTION()->prepare($sql);
        $statement->execute();
    }
}
$implement = new Method();
$implement->CREATE_DB();