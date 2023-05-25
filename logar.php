<?php
session_start();
include_once('conexao.php');
include_once('password.php');

$emailUsuario = trim($_POST['usuario']);
$senhaDigitada = trim($_POST['senha']);

$sql = "SELECT Email, Senha, IdUsuario FROM usuario WHERE Email = '$emailUsuario' AND Status = 'Atvivo'";
$retornoEmailUsuario = mysql_query($conexao,$sql);
$totalRetornado = mysql_num_rows($retornoEmailUsuario);

if($totalRetornado == 0){
    header("Location: index.php?semCadastro=".$emailUsuario);
}
if($totalRetornado >= 2){
    header("Location: index.php?emailCadastrado=".$emailUsuario);
}
if($totalRetornado == 1){
    while($array = mysql_fetch_array($retornoEmailUsuario,MYSQLI_ASSOC)) {
        $senhaCadastrada = $array['senha'];
        $senhaDecodificada = shal($senhaDigitada);
        if($senhaDecodificada == $senhaCadastrada){
            $_SESSION["usuario"] = $array["IdUsuario"];
            header("Location: home.php");
        } else{
            header("Location: index.php?dadosInvalidos=1");
        }
    }
}