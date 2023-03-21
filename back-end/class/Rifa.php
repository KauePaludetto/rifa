<?php
require_once('DataBase.php');
class Rifa{    

    public $id;	
    public $nome;	
    public $descricao;	
    public $imagen_capa;	
    public $numeros;	
    public $valor;	
    public $data_criacao;	
    public $data_encerramento;	
    public $fk_Administrador_email;
    private $erro;

    public function getErro(){
        return $this->erro;
    }

    
    public function cadastrar(){
        $cmdSql = 'CALL rifa_cadastrar (:nome,:descricao,:imagen_capa,:numeros,:valor,:data_encerramento,:fk_Administrador_email)';
        
        $dados = [            
            ':nome' => $this->nome,
            ':descricao' => $this->descricao,
            ':imagen_capa' => $this->imagen_capa,
            ':numeros' => $this->numeros,
            ':valor' => $this->valor,
            ':data_encerramento' => $this->data_encerramento,
            ':fk_Administrador_email' => $this->fk_Administrador_email
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
        $cmdSql = 'CALL rifa_alterar (:id,:nome,:descricao,:imagen_capa,:numeros,:valor,:data_encerramento,:fk_Administrador_email)';
        
        $dados = [
            ':id' => $this->id,       
            ':nome' => $this->nome,
            ':descricao' => $this->descricao,
            ':imagen_capa' => $this->imagen_capa,
            ':numeros' => $this->numeros,
            ':valor' => $this->valor,
            ':data_encerramento' => $this->data_encerramento,
            ':fk_Administrador_email' => $this->fk_Administrador_email
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

    public function consultarPorId($id){
        $cmdSql = "CALL rifa_consultarPorId(:id);";
        $dados = [
            ':id' => $id            
        ];
        $cx = (new DataBase())->connection();
        $cx = $cx->prepare($cmdSql);
        if($cx->execute($dados)){
            $cx->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
            $rifa = $cx->fetch();
            $this->id=$rifa->id;
            $this->nome=$rifa->nome;
            $this->descricao=$rifa->descricao;
            $this->imagen_capa=$rifa->imagen_capa;
            $this->numeros=$rifa->numeros;
            $this->valor=$rifa->valor;
            $this->data_criacao=$rifa->data_criacao;
            $this->data_encerramento=$rifa->data_encerramento;
            $this->fk_Administrador_email=$rifa->fk_Administrador_email;
            return true;
        }
        return false;        
    }

    public function consultarNome($filtro=''){
        $cmdSql = "CALL rifa_consultarNome(:filtro)";
        $dados = [
            ':filtro' => $filtro            
        ];
        $cx = (new DataBase())->connection();
        $cx = $cx->prepare($cmdSql);
        if($cx->execute($dados)){
            return $cx->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        }
        return false;        
    }
    public function consultarPorData($inicio='0000-00-00', $termino='9999-00-00'){
        $cmdSql = "CALL rifa_consultarPorData(:inicio,:termino)";
        $dados = [
            ':inicio' => $inicio,  
            ':termino' => $termino    
        ];
        $cx = (new DataBase())->connection();
        $cx = $cx->prepare($cmdSql);
        if($cx->execute($dados)){
            return $cx->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        }
        return false;        
    }

    public function delete($id){
        $cmdSql = 'CALL rifa_deletar (:id)';
        
        $dados = [            
            ':id' => $id
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
    
    
}