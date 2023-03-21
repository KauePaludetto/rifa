<?php
require_once('DataBase.php');
require_once('Rifa.php');
class Numero{        
    public $fk_rifa_id;	
    public $numero;	
    public $status;	
    public $hora_registro;	
    public $hora_atulalizacao;	
    public $cliente;
    private $erro;

    public function getErro(){
        return $this->erro;
    }

    
    public function cadastrar(){
        $cmdSql = 'CALL numero_cadastrar (:fk_rifa_id,:numero,:cliente)';
        
        $dados = [            
            ':fk_rifa_id' => $this->fk_rifa_id,
            ':numero' => $this->numero,
            ':cliente' => $this->cliente
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

    private function alterarStatus($status){
        $cmdSql = 'CALL 	numero_alterarStatus (:fk_rifa_id,:numero,:status)';
        
        $dados = [
            ':fk_rifa_id' => $this->fk_rifa_id,       
            ':numero' => $this->numero,
            ':status' => $status
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

    public function alterarParaPago(){
        return $this->alterarStatus(2);
    }

    public function alterarParaPendente(){
        return $this->alterarStatus(1);
    }
    
    public function delete($fk_rifa_id, $numero){
        $cmdSql = 'CALL numero_deletar (:id)';
        $dados = [            
            ':fk_rifa_id' => $fk_rifa_id,
            ':numero' => $numero
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
    

    private function listarPorStatus($status){
        $cmdSql = "CALL numero_listarPorStatus(:fk_rifa_id, :status)";
        $dados = [
            ':fk_rifa_id' => $this->fk_rifa_id,    
            ':status' => $status
        ];
        $cx = (new DataBase())->connection();
        $cx = $cx->prepare($cmdSql);
        $cx->execute($dados);
        if($cx->rowCount()){
            return $cx->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        }
        return false;
    }

    public function listarTodos(){
        $rifa = new Rifa();
        $lista_de_numeros = [];
        if($rifa->consultarPorId($this->fk_rifa_id)){
            for($numero = 1; $numero <= $rifa->numeros; $numero++){
                $lista_de_numeros[$numero] = ['status'=>0,	'hora_registro'=>'',	'hora_atulalizacao'=>'',	'cliente'=>''];
            }
            $status = $this->listarPorStatus(0);
            if($status)
            foreach ($status as $numero) {
                $index = $numero->numero;
                $lista_de_numeros[$index]['status'] = $numero->status;
                $lista_de_numeros[$index]['hora_registro'] = $numero->hora_registro;
                $lista_de_numeros[$index]['hora_atulalizacao'] = $numero->hora_atulalizacao;
                $lista_de_numeros[$index]['cliente'] = $numero->cliente;
            }  
            return $lista_de_numeros;
        }
        else{
            return false;
        }
    }

    
}