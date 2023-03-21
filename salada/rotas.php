<?php
//$rota_home
$rotas =[
    'rifa-alterar'=>'view/rifa_alterar.php',
    'rifa-cadastrar'=>'view/rifa_cadastrar.php',
    'rifa-id'=>'view/rifa_id.php',
    'rifa-listar'=>'view/rifa_listar.php',
    'page-erro'=>'view/page_erro.php',
    'admin-cadastrar'=>'view/admin_cadastrar.php',
        
];
if(isset($admin_logado)){

    if(count($_GET)){
        $rota = array_keys($_GET)[0];
        if(isset($rotas[$rota])){
            require_once($rotas[$rota]);
        }
        else{
            require_once($rotas['page-erro']);        
        }
    }
    else{
        require_once($rotas['rifa-listar']);  
    }

}
else{
    require_once('view/login.php');
}