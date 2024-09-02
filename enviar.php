<?php
// Conexão com o banco de dados
$host = "localhost";
$port = 3306;
$socket = "";
$usuario = 'root';
$senha = "";
$bdnome = "cadastro";

$conexao = new mysqli ($host, $usuario, $senha, $bdnome, $port, $socket);

// Verificar se há erros na conexão
if ($conexao->connect_error) {
    die("Erro de conexão: ". $conexao->connect_error);
}

// Verificar se o formulário foi enviado
if(isset($_POST)) {
    // Pegar os dados do formulário
    $nome = $_POST['nome'];
    $nascimento = $_POST['nascimento'];
    $genero = $_POST['genero'];
    $nome_materno = $_POST['nome_materno'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST ['confirmar_senha'];
    $cep = $_POST['cep'];
    $uf = $_POST['uf'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $bairro = $_POST['bairro'];
    $localidade = $_POST['localidade'];
    $senioridade = $_POST['senioridade'];
    $html = isset($_POST['html'])? 1 : 0;
    $css = isset($_POST['css'])? 1 : 0;
    $javascript = isset($_POST['javascript'])? 1 : 0;
    $c = isset($_POST['c'])? 1 : 0;
    $python = isset($_POST['python'])? 1 : 0;
    $java = isset($_POST['java'])? 1 : 0;
    $php = isset($_POST['php'])? 1 : 0;
    $bio = $_POST['bio'];
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];

    // Atualizar os dados no banco de dados
    $sql = "UPDATE desenvolvedor SET 
            nome='$nome', 
            nascimento='$nascimento', 
            genero='$genero', 
            nome_materno='$nome_materno', 
            cpf='$cpf', 
            email='$email', 
            celular='$celular', 
            telefone='$telefone', 
            senha='$senha', 
            confirmar_senha='$confirmar_senha', 
            cep='$cep', 
            uf='$uf', 
            logradouro='$logradouro', 
            numero='$numero', 
            complemento='$complemento', 
            bairro='$bairro', 
            localidade='$localidade', 
            senioridade='$senioridade', 
            html='$html', 
            css='$css', 
            javascript='$javascript', 
            c='$c', 
            python='$python', 
            java='$java', 
            php='$php', 
            bio='$bio', 
            linkedin='$linkedin', 
            github='$github' 
            WHERE email='$email'";

    if ($conexao->query($sql) === TRUE) {
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar dados: ". $conexao->error;
    }
}
?>