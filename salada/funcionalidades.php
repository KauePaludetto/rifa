<?php
session_start();
require_once ('../back-end/class/Administrador.php');
require_once ('../back-end/class/Numero.php');
require_once ('../back-end/class/Rifa.php');

//$rota_home = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];



if(isset($_POST['inputLogin'])){
    $inputEmail = $_POST['inputEmail'];
    $inputSenha = $_POST['inputSenha'];

    $admin = new Administrador();
    if($admin->login($inputEmail,$inputSenha)){
        $_SESSION['usuario_logado'] = serialize($admin);
    }else{
        echo '<script>alert("Usuário e senha inválidos!!!")</script>';
    }

}

if(isset($_POST['inputSair'])){
    unset($_SESSION['usuario_logado']);
}

if(isset($_SESSION['usuario_logado'])){
    $admin_logado = unserialize($_SESSION['usuario_logado']);
}

if(isset($admin_logado)){
    // echo 'tudo aqui';
}