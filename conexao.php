<?php

$host = "localhost";
$usuario = 'root';
$senha = "";
$bdnome = "cadastro";

try {
    // Estabelece a conexão PDO com o banco de dados
    $conexao = new PDO("mysql:host=$host;dbname=$bdnome", $usuario, $senha);
    // Define o modo de erro para exceções
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Em caso de falha na conexão, exibe uma mensagem de erro
    echo "Erro na conexão: " . $e->getMessage();
    // Encerra o script
    exit();
} 

?>