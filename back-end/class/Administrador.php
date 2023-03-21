<?php
require_once('DataBase.php');
class Administrador{    
    public $email;	
    public $senha;	
    public $nome;
    public $telefone;
    private $erro;

    public function getErro(){
        return $this->erro;
    }

    public function cadastrar(){
        $cmdSql = 'CALL administrador_cadastrar (:email, :senha, :nome, :telefone)';
        $this->senha = $this->criptografarSenha($this->senha);
        $dados = [
            ':email' => $this->email, 
            ':senha' => $this->senha, 
            ':nome' => $this->nome,
            ':telefone' => $this->telefone
        ];
        try {
            $cx = (new DataBase())->connection();
            $cx = $cx->prepare($cmdSql);
            return $cx->execute($dados);
        }catch (\PDOException $Exception) {
            $this->erro = $Exception->getMessage();
            return false;
        }
    }

    public function alterar(){
        $cmdSql = 'CALL administrador_alterar (:email, :senha, :nome:, :telefone)';
        $this->senha = $this->criptografarSenha($this->senha);
        $dados = [
            ':email' => $this->email, 
            ':senha' => $this->senha, 
            ':nome' => $this->nome,
            ':telefone' => $this->telefone
        ];
        try {
            $cx = (new DataBase())->connection();
            $cx = $cx->prepare($cmdSql);
            return $cx->execute($dados);
        }catch (\PDOException $Exception) {
            $this->erro = $Exception->getMessage();
            return false;
        }        
    }

    public function consultarPorEmail($email){
        $cmdSql = "CALL administrador_consultarPorEmail(:email);";
        $dados = [
            ':email' => $email            
        ];
        $cx = (new DataBase())->connection();
        $cx = $cx->prepare($cmdSql);
        if($cx->execute($dados)){
            $cx->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
            $adm = $cx->fetch();
            $this->email = $adm->email;	
            $this->senha = $adm->senha;	
            $this->nome = $adm->nome;
            return true;
        }
        return false;        
    }


    private function criptografarSenha($senha): string{
        return password_hash($senha,PASSWORD_BCRYPT,['cost' => 12]);
    }

    private function decriptografarSenha($senha, $criptografia):bool{
        return password_verify($senha, $criptografia);
    }

    public function login($email,$senha):bool{
        if($this->consultarPorEmail($email)){
            return $this->decriptografarSenha($senha,$this->senha);
        }
        return false;
    }
    
}