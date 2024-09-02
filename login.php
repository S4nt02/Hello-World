
<?php /*
include_once("conexao.php");

session_start();
$_SESSION['user'] = $_POST['login'];

try {
    // Estabelece a conexão PDO com o banco de dados
    $connection = new PDO("mysql:host=$host;dbname=$bdnome", $usuario, $senha);
    // Define o modo de erro para exceções
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Em caso de falha na conexão, exibe uma mensagem de erro
    echo "Erro na conexão: " . $e->getMessage();
    // Encerra o script
    exit();
}

$randon = mt_rand(1,3);
function perguntasAleatorias($randon){
    if($randon == 1){   
        echo("<script type='text/javascript'>  var resposta = prompt('Informe sua data de nascimento(no formato yyyy-mm-dd):'); </script>");
    }else if($randon == 2){
        echo("<script type='text/javascript'>  var resposta = prompt('Informe o nome materno:'); </script>");
    }else if($randon == 3){
        echo("<script type='text/javascript'>  var resposta = prompt('Informe seu Documento:'); </script>");
    }
    $resposta = "<script type='text/javascript'> document.write(resposta); </script>";
    return($resposta);
}

if (isset( $_POST['acessar'])) {
    $email = $_POST['login'];
    $senha = $_POST['senha'];

    if(empty($email) || empty($senha)) {
        echo("<script type='text/javascript'> alert('Erro ao se autenticar , tente novamente'); </script>");
        die();
    }

    $query = "SELECT email from desenvolvedor where email =:email ";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() != 0) {
        if ($_POST['login'] == 'master') {
            header("Location: master.php");
            exit();
        } 
        else {
            $respostaLogin = perguntasAleatorias($randon);

            if ($randon == 2) {
                $consulta = "SELECT * from desenvolvedor where email = :email and nome_materno = :resposta";
                $stmt = $connection->prepare($consulta);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':resposta', $respostaLogin, PDO::PARAM_STR);
                $stmt->execute();
            } 
            elseif ($randon == 1) {
                $consulta = "SELECT * from desenvolvedor where email = :email and nascimento = :resposta";
                $stmt = $connection->prepare($consulta);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':resposta', $respostaLogin, PDO::PARAM_STR);
                $stmt->execute();
            } 
            else if ($randon == 3) {
                $consulta = "SELECT * from desenvolvedor where email= :email cpf = :resposta";
                $stmt = $connection->prepare($consulta);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':resposta', $respostaLogin, PDO::PARAM_STR);
                $stmt->execute();
            }

            if ($stmt->rowCount() == 0) {
                echo("<script type='text/javascript'> alert('Erro ao se autenticar , tente novamente'); </script>");
                die();
            } 
            else {
                header("refresh:0.1;perfil.php");
            }
        }
    } 
    else {
        echo("<script type='text/javascript'> alert('Erro ao se autenticar , tente novamente'); </script>");
        die();
    }
} */
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.style.css">
    <link rel="website icon" href="IMG/logo.png">
    <link rel="stylesheet" href="css/media_login.css">
</head>
<body>
    <section class="area-login">
        <div class="login"> 
            <div class="title">
                <a href="index.php"><img src="IMG/logo.png" id="logo">
                <h3>HELLO WORLD</h3></a>
            </div>
            <div class="form">
                <form method="post">
                    <div class="teste"><svg width="25" height="25" fill="none" stroke="#c5c6c7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <path d="M12 3a4 4 0 1 0 0 8 4 4 0 1 0 0-8z"></path>
                      </svg><input type="text" name="login" placeholder="email" autofocus><br></div>
                      <div class="teste"><svg width="25" height="25" fill="none" stroke="#c5c6c7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                      </svg><input type="text" name="senha" placeholder="senha"><br></div>
                    <div id="botão">
                        <span>Esqueceu sua senha?</span>
                      <input type="submit" name="acessar" value="LOGIN">
                    </div>
                </form>
            </div>
            <div class="cadastro">
                <p>ainda não tem conta?<a href="cad.php">CADASTRE-SE</a></p>
            </div>
       </div>
    </section>
    <header>
    <div id="button">
      <input type="checkbox" id="toggleCheckbox">
      <label for="toggleCheckbox">
        <i class="fas fa-moon"></i>
        <i class="fas fa-sun"></i>
      </label>
    </div>
  </header>
  <script src = "js/script.js"></script>
</body>
</html>