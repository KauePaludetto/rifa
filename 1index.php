<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // require_once 'back-end/class/Administrador.php';
        // $Admin = new Administrador();
        // $Admin->email = 'jhonykl@gmail.com';
        // $Admin->senha = 'este123';
        // $Admin->nome = 'Jhony Alex';
        // $Admin->telefone = '159888777';
        // if(!$Admin->cadastrar()){
        //     echo $Admin->getErro();
        // }

        // var_dump($Admin->login('jhonykl@gmail.com','este123'), $Admin);

        require_once 'back-end/class/Rifa.php';
        $rifa = new Rifa();
        //var_dump($rifa->delete(4));
        // $rifa->nome = "Riafa Jhony";	
        // $rifa->descricao = "Teste Rifa Jhony";	
        // $rifa->imagen_capa = "teste.png";	
        // $rifa->numeros = "50";	
        // $rifa->valor = 10;		
        // $rifa->data_encerramento = "2023-05-10";	
        // $rifa->fk_Administrador_email = 'jhonykl@gmail.com' ;
        // var_dump($rifa->cadastrar());

        //var_dump($rifa->consultarPorData('2023-03-09','2023-03-10'));

        require_once('back-end/class/Numero.php');
        $numero = new Numero();        
        $numero->fk_rifa_id = 7;
        $numero->numero = 1;
        // $numero->cliente = "Eliton Camargo; 14997886655";
        // $numero->cadastrar();
        $numero->alterarParaPago();
        var_dump($numero->listarTodos())
    ?>
</body>
</html>

