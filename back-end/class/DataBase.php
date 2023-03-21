<?php
class DataBase{
    private $host;
    private $db;
    private $user;
    private $pass;

    public function __construct(){
        $this->host = 'localhost';
        $this->db = 'rifa';
        $this->user = 'root';
        $this->pass = '';
    }
    public function connection(){
        return new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
    }
}