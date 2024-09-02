

<?php /*

$host = "localhost";
$port = 3306;
$socket = '';
$usuario = 'root';
$senha = "";
$bdnome = "cadastro";

session_start();
$_SESSION['user'] = $_POST['email'];

$conexao = new mysqli ($host, $usuario, $senha, $bdnome, $port, $socket);
  
  $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

  unset($dados['enviar']);

  if(isset($_POST['enviar']))
  {
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

    // SANITIZE = LIMPEZA DE DADOS

    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $nome_materno = filter_input(INPUT_POST, 'nome_materno', FILTER_SANITIZE_SPECIAL_CHARS);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_NUMBER_INT);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_NUMBER_INT);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmar_senha = filter_input(INPUT_POST, 'confirmar_senha', FILTER_SANITIZE_SPECIAL_CHARS);
    $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_NUMBER_INT);
    $uf = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_SPECIAL_CHARS);
    $loradouro = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_SPECIAL_CHARS);
    $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
    $complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_SPECIAL_CHARS);
    $bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_SPECIAL_CHARS);
    $localidade = filter_input(INPUT_POST, 'localidade', FILTER_SANITIZE_SPECIAL_CHARS);

    $erros = []; //array de erros


    // VALIDAÇÃO CPF

    if (!empty($_POST['nome'])) {
      $sem_acentos = iconv('UTF-8', 'ASCII//TRANSLIT', $_POST['nome']);
      $caracteres = preg_replace('/[^a-zA-Z\s]/', '', $sem_acentos);
      // agora você pode trabalhar com o nome sem acentos, caracteres especiais e números
    
      if ($nome != $caracteres ){
        $erros[] = "Nome incorreto!";
      }
    }

    if (!empty($_POST['nome_materno'])) {
      $sem_acentos = iconv('UTF-8', 'ASCII//TRANSLIT', $_POST['nome_materno']);
      $caracteres = preg_replace('/[^a-zA-Z\s]/', '', $sem_acentos);
      // agora você pode trabalhar com o nome sem acentos, caracteres especiais e números
    
      if ($nome_materno != $caracteres ){
        $erros[] = "Nome da mãe incorreto!";
      }
    }

    function validarCPF($cpf)
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Check if CPF has 11 digits
        if (strlen($cpf) != 11) {
            return false;
        }

        // Check if CPF is not a repetition of digits
        if (str_repeat($cpf[0], 11) == $cpf) {
            return false;
        }

        $weightedSum1 = 0;
        $weightedSum2 = 0;

        for ($i = 0; $i <= 8; $i++) {
            $weightedSum1 += $cpf[$i] * (10 - $i);
        }

        for ($i = 0; $i <= 9; $i++) {
            $weightedSum2 += $cpf[$i] * (11 - $i);
        }

        $mod1 = ($weightedSum1 % 11);
        $mod2 = ($weightedSum2 % 11);

        $digit1 = ($mod1 < 2) ? 0 : 11 - $mod1;
        $digit2 = ($mod2 < 2) ? 0 : 11 - $mod2;

        return ($digit1 == $cpf[9] && $digit2 == $cpf[10]);
    }

    if (!empty($_POST['cpf'])) {
        $cpf = $_POST['cpf'];

        if (validarCPF($cpf)) {
            "CPF válido.";
        } else {
            $erros[] = "CPF inválido.";
        }
    }
    // VALIDAÇÃO EMAIL

    if (!empty($_POST['email']))
    {

      function validaremail($email){
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return true;
        }else{
            return false;
        };
      }

      if (validaremail($email) == true){
        $erros[] = "EMAIL INVALIDO";}
    }

    if (!empty($_POST['celular'])) {
      $celular = $_POST['celular'];
      if (strlen($celular) != 11) {
          $erros[] = "Informe um número de celular válido com apenas 11 caracteres.";
      } elseif (!filter_var($celular, FILTER_VALIDATE_INT)) {
          $erros[] = "Informe um Telefone celular somente com números.";
      }
    }

    if (!empty($_POST['telefone'])) {
      $telefone = $_POST['telefone'];
      if (strlen($telefone) != 10) {
          $erros[] = "Informe um número de telefone válido com apenas 10 caracteres.";
      } elseif (!filter_var($telefone, FILTER_VALIDATE_INT)) {
          $erros[] = "Informe um telefone fixo somente com números.";
      }
    }

    if (!empty($_POST['senha'])) {
      $senha = $_POST['senha'];
      if(!empty($_POST['confirmar_senha'])){
        $confirmar_senha = $_POST['confirmar_senha'];
        if ($confirmar_senha != $senha)
        $erros[] = "As senhas devem ser compativéis";
      }
      if (strlen($senha) < 8) {
          $erros[] = "A senha deve ter no mínimo 8 caracteres";
          $erros[] = "A senha deve conter pelo menos 1 letra maiúscula";
          $erros[] = "A senha deve conter pelo menos 1 caractere especial";
      } elseif (!preg_match('/[A-Z][-^a-zA-Z0-9]/', $senha)) {
          $erros[] = "A senha deve conter pelo menos 1 letra maiúscula e 1 caractere especial.";
      }
    }

    if (!empty($_POST['cep'])) {
      $cep = $_POST['cep'];
      $a = preg_replace('/[^0-9]/', '', $cep);
      if (strlen($cep) != 8){
          $erros[] = "O cep deve conter 8 digitos!";
      } elseif (!filter_var($cep, FILTER_VALIDATE_INT) && $cep != $a) {
          $erros[] = "O cep está incorreto!";
      }
    }

    if (!empty($_POST['uf'])) {
      $uf = $_POST['uf'];
      $b = preg_replace('/[^a-zA-Z\s]/', '', $uf);
      if (strlen($uf) != 2 || $uf != $b){
          $erros[] = "UF está incorreto!";
      }
    }

    if (!empty($_POST['logradouro'])) {
      $logradouro = $_POST['logradouro'];
      if ($logradouro == ""){
        $erros[] = "Informe Logradouro!";
      }
    }

    if (!empty($_POST['numero'])){
      $numero = $_POST['numero'];
      $x = preg_replace('/[^0-9]/', '', $numero);
      if ( $numero != $x){
        $erros[] = "Número da residência incorreto, informe somente números!";
      }elseif(!filter_var($celular, FILTER_VALIDATE_INT)){
        $erros[] = "Número da residência incorreto!";
      }
    }

    if(!empty($erros))
    {
      foreach($erros as $erro){
        $erro;
      }
    }elseif(in_array('', $dados)){
      $erro2= "Erro: Preencha todos os campos!";
    }
    else{
        // Verificar se a conexão com o banco de dados foi estabelecida com sucesso
      if ($conexao->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conexao->connect_error);
      }

      // Preparar a query de inserção
      $stmt = $conexao->prepare("INSERT INTO recrutador (nome, nascimento, genero, nome_materno, cpf, email, celular, telefone, senha, cep, uf, logradouro, numero, complemento, bairro, localidade) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt2 = $conexao->prepare("INSERT INTO usuario (nome, nascimento, nome_materno, cpf, login, senha) VALUES (?, ?, ?, ?, ?, ?)");

      // Bindar os parâmetros
      $stmt->bind_param("ssssssssssssssss", $nome, $nascimento, $genero, $nome_materno, $cpf, $email, $celular, $telefone, $senha, $cep, $uf, $logradouro, $numero, $complemento, $bairro, $localidade);
      $stmt2->bind_param("ssssss", $nome, $nascimento, $nome_materno, $cpf, $email, $senha);
      // Executar a query
      if ($stmt->execute()) {
        if ($stmt2->execute())
        header("refresh:0.1;perfil.php");
      } else {
          echo "Erro ao inserir dados: " . $stmt->error;
      }
    }
    $conexao->close();
  }  */
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hello World</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/cadastro.style.css">
  <link rel="website icon" href="IMG/logo.png">
</head>
<body>
  <main>
    <div class="menu">
      <div class="title">
        <img src="IMG/logo.png">
        <a href="index.html"><h3>HELLO WORLD</h3></a>
      </div>
      <div class="foto-perfil">
        <img src="#" alt="foto do usuário" id="perfil-img"><br>
        <label for="upload" id="file-upload">
          Escolha sua foto de perfil
        </label>
        <input id="upload" type="file">
      </div>
      <div class="sub-menu">
        <h3 class="option"> 
          <svg width="30" height="30" fill="none" stroke="#c5c6c7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <path d="M12 3a4 4 0 1 0 0 8 4 4 0 1 0 0-8z"></path>
          </svg>
          <a href="#dados-pessoais" data-anchor="anchor-1">DADOS PESSOAIS</a>
        </h3>
        <h3 class="option">
          <svg width="30" height="30" fill="none" stroke="#c5c6c7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 6v16l7-4 8 4 7-4V2l-7 4-8-4-7 4z"></path>
            <path d="M8 2v16"></path>
            <path d="M16 6v16"></path>
          </svg>
          <a href="#endereço" data-anchor="anchor-2">ENDEREÇO</a>
        </h3>
      </div>
      <div class="login">
        Já possui conta? Faça <a href="login.php">Login</a>
      </div>
    </div>
    <div id="dados">
      <form id="form" method="POST" name="form">
        <div class="dados-content">
          <h2 class="content-title"><a id="anchor-1">DADOS PESSOAIS</a></h2><hr>
          <div class="nome">
            <small class="input-title"> Nome Completo:</small> <br>
            <input type = "text"  id="nome-completo" name="nome"  placeholder="Digite o nome completo.." class="input require" />
            <span class="span-required">Nome deve ter 15 caracteres</span>
          </div>
          <br>
          <div class="nascimento">
            <small class="input-title">Data de nascimento:</small> <br>
            <input type="date"  id="data-nascimento" name="nascimento" placeholder="Digite a data de nascimento.." />
          </div>
          <div class="sexo">
            <small class="input-title"> Gênero</small><br>
            <select name="genero" id="Gênero" >
              <option >Feminino</option>
              <option >Masculino</option>
            </select>
          </div>
          <br>
          <div class="nome-materno">
            <small class="input-title">Nome da Mãe:</small><br>
            <input type="text"  id="nome-materno" name="nome_materno" placeholder="Digite o nome da sua mãe.."  class="input require" />
            <span class="span-required">Nome deve ser válido</span>
          </div>
          <br>
          <div class="cpf">
            <small class="input-title">CPF:</small><br>
            <input type="number" id="cpf" name="cpf" placeholder="Digite o seu CPF.." class="input require" maxlength="11" />
            <span class="span-required">CPF deve ser válido</span>
          </div>
          <div class="email">
            <small calss="input-title">E-mail:</small><br>
            <input  type="text"  id="email" name="email" placeholder="Digite o seu email.." class="input require"  />
            <span class="span-required">Informe um email válido</span>
          </div>
          <br>
          <div class="celular">
            <small class="input-title">Celular:</small><br>
            <input type="number" id="celular" name="celular" maxlength="11" placeholder="Digite o seu telefone celular.." class="input require"  />
            <span class="span-required">informe um número de celular válido</span>
          </div>
          
          <div class="tel-fixo">
            <small class="input-title">Telefone fixo:</small><br>
            <input type="number"  id="tel-fixo" name="telefone" maxlength="10" placeholder="Digite o seu telefone fixo.." class="input require"  />
            <span class="span-required">Informe um número de telefone válido</span>
          </div>
          <br>
          <div class="senha">
            <small class="input-title">Senha:</small><br>
            <input  type="password"  id="senha" name="senha" placeholder="Digite a sua senha.." class="input require" />
            <span class="span-required">Senha deve conter no minimo 8 caracteres</span>
          </div>
          
          <div class="confirmar-senha">
            <small class="input-title">Confime sua senha:</small><br>
            <input type="password"  id="confirmar-senha" name="confirmar_senha" placeholder="confirme sua senha.."  class="input require" />
            <span class="span-required">As senhas devem ser compatíveis</span>
          </div>
        </div>
        
        <br>

        <a id="anchor-2"></a><div class="endereco">
          <h2 class="content-title">ENDEREÇO</h2><hr>
          <div class="cep">
            <small class="input-title">CEP:</small><br>
              <input type="text" id="cep" name="cep" placeholder="Digite seu CEP"  class="input require" >
              <span class="span-required"></span>
          </div>
          <div class="uf">
            <small class="input-title">UF:</small><br>
            <input type="text" id="uf" name="uf" placeholder="'RJ'"  class="input require">
            <span class="span-required"></span>
          </div>
          <br>
          <div class="logadouro">
            <small class="input-title">Logradouro:</small><br>
            <input type="text" id="logadouro" name="logradouro" placeholder="Digite seu endereço completo"  class="input require">
            <span class="span-required"></span>
          </div>
          <br>
          <div class="numero">
            <small class="input-title">Número:</small><br>
            <input type="text" id="numero" name="numero" placeholder="Num. da residência"  class="input require" >
            <span class="span-required"></span>
          </div>
          
          <div class="complemento">
            <small class="input-title">Complemento:</small><br>
            <input type="text" id="complemento" name="complemento" placeholder="Exemplo(Apt:402)"  class="input require" >
            <span class="span-required"></span>
          </div>
          <br>
          <div class="bairro">
            <small class="input-title">Bairro</small><br>
            <input type="text" id="bairro" name="bairro" placeholder="Bairro em que reside"  class="input require" >
            <span class="span-required"></span>
          </div>
          <div class="localidade">
            <small class="input-title">Localidade</small><br>
            <input type="text" id="localidade" name="localidade" placeholder="Municipío em que reside"  class="input require">
            <span class="span-required"></span>
          </div>
          <br>
        </div>
        <br>
        <div class="botao">
          <button type="submit" class="bt-enviar" name="enviar">Enviar</button>
          <button class="bt-limpar">Limpar</button>
          <?php 
            if(isset($erro)){
              echo $erro;
            }elseif(isset($erro2)){
              echo $erro2;
            }
          ?>
        </div> 
      </form>
    </div>
  </main>
  <header>
    <div id="button">
      <input type="checkbox" id="toggleCheckbox">
      <label for="toggleCheckbox">
        <i class="fas fa-moon"></i>
        <i class="fas fa-sun"></i>
      </label>
    </div>
  </header>
  <script>
    
    const overflowDiv = document.getElementById('dados');
  
    
    const menuItems = document.querySelectorAll('.sub-menu');
  
    
    menuItems.forEach((menuItem) => {
      menuItem.addEventListener('click', (event) => {
        
        const anchorId = event.target.getAttribute('data-anchor');
  
        
        const anchorElement = overflowDiv.querySelector(`#${anchorId}`);
  
        
        const anchorOffsetTop = anchorElement.offsetTop;
  
        
        const parentOffsetTop = anchorElement.parentNode.offsetTop;
  
        
        const scrollPosition = anchorOffsetTop - parentOffsetTop;
  
        
        overflowDiv.scrollTop = scrollPosition;
      });
    });

    (function(){ 
 
 const cep = document.getElementById("cep");

 cep.addEventListener('blur', e=> {
      const value = cep.value.replace(/[^0-9]+/, '');
      const url = `https://viacep.com.br/ws/${value}/json/`;

    fetch(url)
   .then( response => response.json())
   .then( json => {
              
       if( json.logradouro ) {
         document.querySelector('input[name=logradouro]').value = json.logradouro;
             document.querySelector('input[name=bairro]').value = json.bairro;
             document.querySelector('input[name=localidade]').value = json.localidade;
             document.querySelector('input[name=uf]').value = json.uf;
       }
      
    
   });
});

})();
  </script>
    <script src = "script.js"></script>
</body>
</html>
