<?php
  $host = "localhost";
  $port = 3306;
  $socket = '';
  $usuario = 'root';
  $senha = "";
  $bdnome = "cadastro";

  $conexao = new mysqli ($host, $usuario, $senha, $bdnome, $port, $socket);

session_start();
if(!isset($_SESSION['user'])){
  header('location:login.php');
  exit;
}
else{
  $usuario = $_SESSION['user'] ;

  $sql = "SELECT * FROM desenvolvedor WHERE email = '$usuario'";
  $result = mysqli_query($conexao, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HELLO WORLD</title>
  <link rel="stylesheet" href="css/master.css">
  <link rel="stylesheet" href="media_master.css">
  <link rel="shortcut icon" href="IMG/logo.png">
</head>
<body>
    <header class="header">
        <ul class="navbar">
            <li class="home">
                <div id="logo">
                    <img src="IMG/logo.png" alt="HELLO WORLD">
                    <h1>HELLO WORLD</h1>
                </div>
            </li>
            <li>
                <div id="button">
                    <input type="checkbox" id="toggleCheckbox">
                    <label for="toggleCheckbox">
                      <i class="fas fa-moon"></i>
                      <i class="fas fa-sun"></i>
                    </label>
                </div>
            </li>
        </ul>
    </header>
    <main>
        <h2>USUÁRIOS</h2>
        <table>
            <tr>
                <td><strong>ID</strong></td>
                <td><strong>NOME</strong></td>
                <td><strong>GENÊRO</strong></td>
                <td><strong>DATA DE NASCIMENTO</strong></td>
                <td><strong>EMAIL</strong></td>
                <td><strong>CPF</strong></td>
                <td><strong>TELEFONE</strong></td>
                <td><strong>APAGAR</strong></td>
            </tr>
            
            <?php
$host = "localhost";
$port = 3306;
$socket = '';
$usuario = 'root';
$senha = "";
$bdnome = "cadastro";

$conexao = new mysqli ($host, $usuario, $senha, $bdnome, $port, $socket);


// Consulta para buscar os usuários ordenados por ID
$result = mysqli_query($conexao, "SELECT * FROM usuario ORDER BY id DESC");

// Loop para exibir os usuários
while ($res = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $res['id'] . "</td>";
    echo "<td>" . $res['nome'] . "</td>";
    echo "<td>" . $res['genero'] . "</td>";
    echo "<td>" . $res['nascimento'] . "</td>";
    echo "<td>" . $res['email'] . "</td>";
    echo "<td>" . $res['cpf'] . "</td>";
    echo "<td>" . $res['telefone'] . "</td>";
    echo "<td><a href=\"?email=" . $res['email'] . "\" onClick=\"return confirm('Tem certeza que deseja deletar o usuário?')\">Delete</a></td>";
    echo "</tr>";
}

if (isset($_GET['email'])) {
    $id = $_GET['email'];
    
    $result1 = mysqli_query($conexao, "DELETE FROM recrutador WHERE email = '$id'");
    echo "Consulta para excluir usuário: " . $conexao->error . "<br>"; 
    
    if (!$result1) {
        $result2 = mysqli_query($conexao, "DELETE FROM desenvolvedor WHERE email = '$id'");
        echo "Consulta para excluir usuário (segunda tentativa): " . $conexao->error . "<br>"; 
    }

    if ($result1 || $result2) {
        session_start();
        $_SESSION['delete_success'] = true; 
        echo "Sessão iniciada com sucesso<br>"; 
        header("Location: master.php"); 
        echo "Redirecionando para a página master.php<br>";
    } else {
        echo "<script>alert('Erro ao deletar usuario!');</script>";
    }
}

session_start();
$delete_success = isset($_SESSION['delete_success']) ? $_SESSION['delete_success'] : false;
if ($delete_success) {
    echo "<script>alert('Usuário deletado com sucesso!');</script>";
    unset($_SESSION['delete_success']); 
    echo "Variável delete_success definida com sucesso<br>"; // Verificar variável
}
?>
        </table>
    </main>
    <script src = "js/script.js"></script>
</body>
</html>
