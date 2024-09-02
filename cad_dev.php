
<?php /*
  
  $host = "localhost";
  $port = 3306;
  $socket = '';
  $usuario = 'root';
  $senha = "";
  $bdnome = "cadastro";

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
    $bio = $_POST['apresentacao'];
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];

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
      if(isset($_POST['enviar'])){
        if (isset($_POST['cad'])){
        $teste = implode("', '", $_POST['cad']);

        $html = in_array('html', $_POST['cad']) ? 1 : 0;
        $css = in_array('css', $_POST['cad']) ? 1 : 0;
        $javascript = in_array('javascript', $_POST['cad']) ? 1 : 0;
        $c = in_array('c', $_POST['cad']) ? 1 : 0;
        $python = in_array('python', $_POST['cad']) ? 1 : 0;
        $java = in_array('java', $_POST['cad']) ? 1 : 0;
        $php = in_array('php', $_POST['cad']) ? 1 : 0;

        $stmt = $conexao->prepare("INSERT INTO desenvolvedor (nome, nascimento, genero, nome_materno, cpf, email, celular, telefone, senha, cep, uf, logradouro, numero, complemento, bairro, localidade, html, css, javascript, c, python, java, php, bio, linkedin, github) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bindar os parâmetros
        $stmt->bind_param("ssssssssssssssssssssssssss", $nome, $nascimento, $genero, $nome_materno, $cpf, $email, $celular, $telefone, $senha, $cep, $uf, $logradouro, $numero, $complemento, $bairro, $localidade, $html, $css, $javascript, $c, $python, $java, $php, $bio, $linkedin, $github);
        }
      }

      // Executar a query
      if ($stmt->execute()) {
          header("refresh:0.1;perfil.php");
      } else {
          echo "Erro ao inserir dados: " . $stmt->error;
      }
    }
  } */
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
        <h3 class="option"> <svg width="30" height="30" fill="none" stroke="#c5c6c7" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          <path d="M14 2v6h6"></path>
          <path d="M16 13H8"></path>
          <path d="M16 17H8"></path>
          <path d="M10 9H8"></path>
          </svg>
          <a href="#curriculo" data-anchor="anchor-3">CURRÍCULO</a>
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

        <a id="anchor-3"></a><div class="curriculo">
          <h2 class="content-title">Currículo</h2><hr>
          <p>Queremos conhecher mais de você para exibir seu perfil aos recrutadores. Para isso preenchar os campos a seguir.</p>
          <br>
          <div class="nivel">
            <small class="input-title">Qual seu nível de experiência:</small>
            <select name="senioridade" id="nivel">>
              <option value="" data-default disabled selected></option> <!-- Select começa em -->
              <option value="junior">Júnior</option>
              <option value="pleno">Pleno</option>
              <option value="senior">Sênior</option>
            </select> 
          </div>

          <br>

          <div class="linguagens">
            <small class="input-title">Selecione as linguaguens que você tem experiência:</small><br><br>
            
            <div class="front">
              <div><input type="checkbox" id="html" name="cad[]" value="html">
                <label for="html" class="checkbox"> <svg height="200px" width="200px" xmlns="http://www.w3.org/2000/svg" aria-label="HTML5" role="img" viewBox="0 0 512 512" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#e34f26" d="M71 460L30 0h451l-41 460-185 52"></path><path fill="#ef652a" d="M256 472l149-41 35-394H256"></path><path fill="#ebebeb" d="M256 208h-75l-5-58h80V94H114l15 171h127zm-1 147l-63-17-4-45h-56l7 89 116 32z"></path><path fill="#ffffff" d="M255 208v57h70l-7 73-63 17v59l116-32 16-174zm0-114v56h137l5-56z"></path></g></svg>
                </label>
              </div>

              <div><input type="checkbox" id="css" name="cad[]" value="css">
                <label for="css" class="checkbox"><svg height="200px" width="200px" xmlns="http://www.w3.org/2000/svg" aria-label="CSS3" role="img" viewBox="0 0 512 512" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#264de4" d="M72 460L30 0h451l-41 460-184 52"></path><path fill="#2965f1" d="M256 37V472l149-41 35-394"></path><path fill="#ebebeb" d="m114 94h142v56H119m5 58h132v57H129m3 28h56l4 45 64 17v59L139 382"></path><path fill="#ffffff" d="m256 208v57h69l-7 73-62 17v59l115-32 26-288H256v56h80l-5.5 58Z"></path></g></svg>
                </label>
              </div>

              <div><input type="checkbox" id="javascript" name="cad[]" value="javascript">
                <label for="javascript" class="checkbox"><svg xmlns="http://www.w3.org/2000/svg" aria-label="JavaScript" role="img" viewBox="0 0 512 512" width="200px" height="200px" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><rect width="512" height="512" rx="15%" fill="#f7df1e"></rect><path d="M324 370c10 17 24 29 47 29c20 0 33-10 33 -24c0-16 -13 -22 -35 -32l-12-5c-35-15 -58 -33 -58 -72c0-36 27 -64 70 -64c31 0 53 11 68 39l-37 24c-8-15 -17 -21 -31 -21c-14 0-23 9 -23 21c0 14 9 20 30 29l12 5c41 18 64 35 64 76c0 43-34 67 -80 67c-45 0-74 -21 -88 -49zm-170 4c8 13 14 25 31 25c16 0 26-6 26 -30V203h48v164c0 50-29 72 -72 72c-39 0-61 -20 -72 -44z"></path></g></svg>
                </label>
              </div>

            </div>

              <br>
            <div class="front">
              
              <div><input type="checkbox" id="c++" name="cad[]" value="c">
                <label for="c++" class="checkbox"><svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M27.6947 22.9999C27.883 22.6617 28 22.2807 28 21.9385V10.0613C28 9.71913 27.8831 9.33818 27.6947 9L16 16L27.6947 22.9999Z" fill="#00599C"></path> <path d="M17.0395 29.7433L26.9611 23.8047C27.2469 23.6336 27.5067 23.3382 27.695 23L16.0003 16L4.30566 23C4.49398 23.3382 4.75382 23.6337 5.03955 23.8047L14.9611 29.7433C15.5326 30.0855 16.468 30.0855 17.0395 29.7433Z" fill="#004482"></path> <path d="M27.6947 8.99996C27.5064 8.6617 27.2465 8.36629 26.9608 8.19521L17.0392 2.25662C16.4677 1.91446 15.5323 1.91446 14.9608 2.25662L5.03922 8.19521C4.46761 8.53729 4 9.37709 4 10.0613V21.9386C4 22.2807 4.11694 22.6618 4.30533 23L16 16L27.6947 8.99996Z" fill="#659AD2"></path> <path d="M16.0385 24C11.6061 24 8 20.4112 8 16C8 11.5888 11.6061 8 16.0385 8C18.8458 8 21.4674 9.47569 22.919 11.8618L19.4765 13.9265C18.7492 12.736 17.4399 12 16.0385 12C13.8222 12 12.0193 13.7944 12.0193 16C12.0193 18.2056 13.8222 20 16.0385 20C17.4362 20 18.7421 19.2681 19.4707 18.0832L22.9205 20.1359C21.4692 22.5234 18.8467 24 16.0385 24Z" fill="white"></path> <path d="M23 15.4948H21.9999V14.5H21.0001V15.4948H20V16.4895H21.0001V17.4844H21.9999V16.4895H23V15.4948Z" fill="white"></path> <path d="M27 15.5H25.9999V14.5H25.0001V15.5H24V16.4999H25.0001V17.5H25.9999V16.4999H27V15.5Z" fill="white"></path> </g></svg>
                </label>
              </div>

              <div><input type="checkbox" id="python" name="cad[]" value="python">
                <label for="python" class="checkbox"><svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.0164 2C10.8193 2 9.03825 3.72453 9.03825 5.85185V8.51852H15.9235V9.25926H5.97814C3.78107 9.25926 2 10.9838 2 13.1111L2 18.8889C2 21.0162 3.78107 22.7407 5.97814 22.7407H8.27322V19.4815C8.27322 17.3542 10.0543 15.6296 12.2514 15.6296H19.5956C21.4547 15.6296 22.9617 14.1704 22.9617 12.3704V5.85185C22.9617 3.72453 21.1807 2 18.9836 2H13.0164ZM12.0984 6.74074C12.8589 6.74074 13.4754 6.14378 13.4754 5.40741C13.4754 4.67103 12.8589 4.07407 12.0984 4.07407C11.3378 4.07407 10.7213 4.67103 10.7213 5.40741C10.7213 6.14378 11.3378 6.74074 12.0984 6.74074Z" fill="url(#paint0_linear_87_8204)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M18.9834 30C21.1805 30 22.9616 28.2755 22.9616 26.1482V23.4815L16.0763 23.4815L16.0763 22.7408L26.0217 22.7408C28.2188 22.7408 29.9998 21.0162 29.9998 18.8889V13.1111C29.9998 10.9838 28.2188 9.25928 26.0217 9.25928L23.7266 9.25928V12.5185C23.7266 14.6459 21.9455 16.3704 19.7485 16.3704L12.4042 16.3704C10.5451 16.3704 9.03809 17.8296 9.03809 19.6296L9.03809 26.1482C9.03809 28.2755 10.8192 30 13.0162 30H18.9834ZM19.9015 25.2593C19.1409 25.2593 18.5244 25.8562 18.5244 26.5926C18.5244 27.329 19.1409 27.9259 19.9015 27.9259C20.662 27.9259 21.2785 27.329 21.2785 26.5926C21.2785 25.8562 20.662 25.2593 19.9015 25.2593Z" fill="url(#paint1_linear_87_8204)"></path> <defs> <linearGradient id="paint0_linear_87_8204" x1="12.4809" y1="2" x2="12.4809" y2="22.7407" gradientUnits="userSpaceOnUse"> <stop stop-color="#327EBD"></stop> <stop offset="1" stop-color="#1565A7"></stop> </linearGradient> <linearGradient id="paint1_linear_87_8204" x1="19.519" y1="9.25928" x2="19.519" y2="30" gradientUnits="userSpaceOnUse"> <stop stop-color="#FFDA4B"></stop> <stop offset="1" stop-color="#F9C600"></stop> </linearGradient> </defs> </g></svg>
                </label>
              </div>

              <div><input type="checkbox" id="java" name="cad[]" value="java">
                <label for="java" class="checkbox"><svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16.0497 8.44062C22.6378 3.32607 19.2566 0 19.2566 0C19.7598 5.28738 13.813 6.53583 12.2189 10.1692C11.1312 12.6485 12.9638 14.8193 16.0475 17.5554C15.7749 16.9494 15.3544 16.3606 14.9288 15.7645C13.4769 13.7313 11.9645 11.6132 16.0497 8.44062Z" fill="#E76F00"></path> <path d="M17.1015 18.677C17.1015 18.677 19.0835 17.0779 17.5139 15.3008C12.1931 9.27186 23.3333 6.53583 23.3333 6.53583C16.5317 9.8125 17.5471 11.7574 19.2567 14.1202C21.0871 16.6538 17.1015 18.677 17.1015 18.677Z" fill="#E76F00"></path> <path d="M22.937 23.4456C29.0423 20.3258 26.2195 17.3278 24.2492 17.7317C23.7662 17.8305 23.5509 17.9162 23.5509 17.9162C23.5509 17.9162 23.7302 17.64 24.0726 17.5204C27.9705 16.1729 30.9682 21.4949 22.8143 23.6028C22.8143 23.6029 22.9088 23.5198 22.937 23.4456Z" fill="#5382A1"></path> <path d="M10.233 19.4969C6.41312 18.9953 12.3275 17.6139 12.3275 17.6139C12.3275 17.6139 10.0307 17.4616 7.20592 18.8043C3.86577 20.3932 15.4681 21.1158 21.474 19.5625C22.0984 19.1432 22.9614 18.7798 22.9614 18.7798C22.9614 18.7798 20.5037 19.2114 18.0561 19.4145C15.0612 19.6612 11.8459 19.7093 10.233 19.4969Z" fill="#5382A1"></path> <path d="M11.6864 22.4758C9.55624 22.2592 10.951 21.2439 10.951 21.2439C5.43898 23.0429 14.0178 25.083 21.7199 22.8682C20.9012 22.5844 20.3806 22.0653 20.3806 22.0653C16.6163 22.7781 14.441 22.7553 11.6864 22.4758Z" fill="#5382A1"></path> <path d="M12.6145 25.6991C10.486 25.4585 11.7295 24.7474 11.7295 24.7474C6.72594 26.1222 14.7729 28.9625 21.1433 26.2777C20.0999 25.8787 19.3528 25.4181 19.3528 25.4181C16.5111 25.9469 15.1931 25.9884 12.6145 25.6991Z" fill="#5382A1"></path> <path d="M25.9387 27.3388C25.9387 27.3388 26.8589 28.0844 24.9252 28.6612C21.2481 29.7566 9.62093 30.0874 6.39094 28.7049C5.22984 28.2082 7.40723 27.5189 8.09215 27.3742C8.80646 27.2219 9.21466 27.2503 9.21466 27.2503C7.9234 26.3558 0.868489 29.0067 5.63111 29.7659C18.6195 31.8372 29.3077 28.8331 25.9387 27.3388Z" fill="#5382A1"></path> <path d="M28 28.9679C27.7869 31.6947 18.7877 32.2683 12.9274 31.8994C9.10432 31.6583 8.33812 31.0558 8.32691 31.047C11.9859 31.6402 18.1549 31.7482 23.1568 30.8225C27.5903 30.0016 28 28.9679 28 28.9679Z" fill="#5382A1"></path> </g></svg>
                </label>
              </div>

              <div>
                <input type="checkbox" id="php" name="cad[]" value="php">
                <label for="php" class="checkbox"><svg width="250px" height="250px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><linearGradient id="a" x1="-134.514" y1="-206.113" x2="-134.455" y2="-206.235" gradientTransform="matrix(247.636, 0, 0, -153.765, 33318.948, -31686.704)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#8a9fe0"></stop><stop offset="0.588" stop-color="#7182b8"></stop><stop offset="1" stop-color="#576490"></stop></linearGradient></defs><title>file_type_php2</title><path d="M14.486,20.381a17.345,17.345,0,0,1-.046,3.133.835.835,0,0,1-.439.709c-.831.617-3.616.765-3.963-.546-.128-.005-.026-.429-.148-.413a1.561,1.561,0,0,1-1.2-.735c.005-1.434.163-6.607-2.4-5.214a2.506,2.506,0,0,0-1.168,1.429,4.91,4.91,0,0,0-.24,1.643c-.02.714.158,1.495.184,2.352.01.383.071.48-.214.806-.459.525-1.26.082-1.693-.495a1.893,1.893,0,0,1-.291-.969,31.065,31.065,0,0,1,1-11.148c.367-1.23.495-1.408,1.663-1.684a12.948,12.948,0,0,1,4.05-.24c1.051-.342,3.545-2.194,4.621-.724a12.527,12.527,0,0,1,9.579,1.75,37.083,37.083,0,0,0,4.259.077c.2-.128.434-.265.638-.383a1.381,1.381,0,0,1,.495-.209c.23-.036.53-.046.6.24a3.292,3.292,0,0,1,.061.893.808.808,0,0,1-.643.76,4.02,4.02,0,0,1-1.148-.372c-1.3.036-2.1-.036-3.4,0,.209.224.2.372.352.668a6.381,6.381,0,0,1-.775,5.979c-.092,1.49.02,2.995.031,4.49.005.515.041,1.005-.444,1.347a3.263,3.263,0,0,1-2.867.24,2.523,2.523,0,0,1-.668-.556,2.807,2.807,0,0,1-.5.01,1.213,1.213,0,0,1-.689-.505,3.606,3.606,0,0,1-.235-.525c0-.7-.026-.974-.026-1.673a10.67,10.67,0,0,1-4.346-.122Z" style="fill:#ccc"></path><path d="M12.095,24.839a3.748,3.748,0,0,1-1.217-.184,1.452,1.452,0,0,1-.972-.864.46.46,0,0,1-.1-.322l0-.045a1.8,1.8,0,0,1-1.25-.811l-.024-.039,0-.26c.009-1.182.032-4.323-1.034-4.962a1.1,1.1,0,0,0-1.128.1,2.356,2.356,0,0,0-1.1,1.349,4.783,4.783,0,0,0-.228,1.588,8.525,8.525,0,0,0,.085,1.2c.043.366.087.746.1,1.145,0,.059,0,.11.007.156a.849.849,0,0,1-.26.76.817.817,0,0,1-.665.288,1.849,1.849,0,0,1-1.276-.792,1.973,1.973,0,0,1-.322-1.053A31.068,31.068,0,0,1,3.719,10.887c.375-1.255.54-1.5,1.779-1.793a13.117,13.117,0,0,1,4.068-.247,8.378,8.378,0,0,0,.875-.4c1.232-.616,2.91-1.453,3.831-.334a12.633,12.633,0,0,1,9.567,1.768A36.054,36.054,0,0,0,28,9.953c.2-.123.412-.251.606-.363l.056-.032a1.366,1.366,0,0,1,.494-.2c.444-.069.7.053.777.361a3.477,3.477,0,0,1,.065.939.97.97,0,0,1-.791.909l-.026,0-.025-.007c-.085-.022-.171-.042-.26-.062A3.127,3.127,0,0,1,28,11.2c-.633.016-1.155.007-1.659,0-.433-.007-.878-.015-1.394-.007.032.063.055.124.08.186a2.467,2.467,0,0,0,.112.256,6.533,6.533,0,0,1-.761,6.126c-.056.966-.027,1.957,0,2.916.015.491.03,1,.033,1.5v.086a1.448,1.448,0,0,1-.513,1.393,3.4,3.4,0,0,1-3.02.257,1.8,1.8,0,0,1-.564-.437c-.035-.036-.07-.072-.106-.106-.049,0-.1.006-.145.011a.952.952,0,0,1-.33-.006,1.375,1.375,0,0,1-.783-.571,1.779,1.779,0,0,1-.171-.361c-.023-.061-.047-.123-.076-.188l-.014-.031v-.034c0-.347-.006-.594-.013-.832-.005-.2-.01-.4-.012-.659a10.815,10.815,0,0,1-4-.092,17.55,17.55,0,0,1-.065,2.931.984.984,0,0,1-.5.813A3.748,3.748,0,0,1,12.095,24.839Zm-1.969-1.318h.036l.03.114a1.106,1.106,0,0,0,.791.718,3.912,3.912,0,0,0,2.922-.259.687.687,0,0,0,.375-.6,17.157,17.157,0,0,0,.055-2.976l-.085-.024L14.6,19.8l.041.463a10.678,10.678,0,0,0,4.169.088l.181-.024v.182c0,.347.006.594.013.832s.012.473.013.807c.025.059.047.116.069.171a1.524,1.524,0,0,0,.139.3,1.057,1.057,0,0,0,.6.44.729.729,0,0,0,.216,0,1.888,1.888,0,0,1,.244-.013l.06,0,.044.041c.054.05.108.105.162.16a1.537,1.537,0,0,0,.46.366,3.1,3.1,0,0,0,2.712-.224c.388-.274.383-.65.377-1.127v-.087c0-.5-.018-1-.033-1.492-.029-.987-.059-2.008,0-3.009l0-.066.05-.044a6.184,6.184,0,0,0,.739-5.785,2.755,2.755,0,0,1-.126-.287.911.911,0,0,0-.2-.346l-.241-.259.353-.01c.654-.018,1.188-.009,1.706,0s1.045.018,1.691,0h.047l.04.025a2.716,2.716,0,0,0,.835.289c.082.019.163.037.242.057a.671.671,0,0,0,.471-.609,3.141,3.141,0,0,0-.058-.847c-.014-.061-.041-.176-.416-.117a1.065,1.065,0,0,0-.384.158l-.056.032c-.2.114-.429.253-.631.379l-.037.023h-.043a36.326,36.326,0,0,1-4.278-.077l-.042,0-.035-.024a12.347,12.347,0,0,0-9.461-1.725l-.1.018-.059-.08c-.747-1.02-2.334-.227-3.493.352a7.889,7.889,0,0,1-.95.43l-.032.01-.033,0a12.792,12.792,0,0,0-4,.236c-1.121.264-1.2.4-1.547,1.574a30.75,30.75,0,0,0-1,11.09,1.683,1.683,0,0,0,.258.884,1.551,1.551,0,0,0,1.033.666.5.5,0,0,0,.413-.179.552.552,0,0,0,.182-.532c0-.049-.006-.1-.007-.164-.011-.386-.055-.758-.1-1.118a8.754,8.754,0,0,1-.087-1.243,5.022,5.022,0,0,1,.251-1.7,2.67,2.67,0,0,1,1.24-1.509,1.4,1.4,0,0,1,1.444-.1c1.223.733,1.2,3.89,1.19,5.238v.167a1.4,1.4,0,0,0,1.028.622.2.2,0,0,1,.15.045.4.4,0,0,1,.1.3C10.123,23.471,10.124,23.5,10.126,23.521Zm-.216-.1h0Z" style="fill:#ccc"></path><path d="M13.891,19.981a17.345,17.345,0,0,1-.046,3.133.835.835,0,0,1-.439.709c-.831.617-3.616.765-3.963-.546-.128-.005-.026-.429-.148-.413a1.561,1.561,0,0,1-1.2-.735c.005-1.434.163-6.607-2.4-5.214a2.506,2.506,0,0,0-1.168,1.429,4.91,4.91,0,0,0-.24,1.643c-.02.714.158,1.495.184,2.352.01.383.071.48-.214.806-.459.525-1.26.082-1.693-.495a1.893,1.893,0,0,1-.291-.969,31.065,31.065,0,0,1,1-11.148c.367-1.23.495-1.408,1.663-1.684a12.948,12.948,0,0,1,4.05-.24c1.051-.342,3.545-2.194,4.621-.724a12.527,12.527,0,0,1,9.579,1.75,37.083,37.083,0,0,0,4.259.077c.2-.128.434-.265.638-.383a1.381,1.381,0,0,1,.495-.209c.23-.036.53-.046.6.24a3.292,3.292,0,0,1,.061.893.808.808,0,0,1-.643.76,4.02,4.02,0,0,1-1.148-.372c-1.3.036-2.1-.036-3.4,0,.209.224.2.372.352.668a6.381,6.381,0,0,1-.775,5.979c-.092,1.49.02,2.995.031,4.49.005.515.041,1.005-.444,1.347a3.263,3.263,0,0,1-2.867.24,2.523,2.523,0,0,1-.668-.556,2.807,2.807,0,0,1-.5.01,1.213,1.213,0,0,1-.689-.505,3.606,3.606,0,0,1-.235-.525c0-.7-.026-.974-.026-1.673a10.67,10.67,0,0,1-4.346-.122Z" style="fill:#373435"></path><path d="M11.5,24.439a3.748,3.748,0,0,1-1.217-.184,1.452,1.452,0,0,1-.972-.864.46.46,0,0,1-.1-.322l0-.045a1.8,1.8,0,0,1-1.25-.811l-.024-.039,0-.26c.009-1.182.032-4.323-1.034-4.962a1.1,1.1,0,0,0-1.128.1,2.356,2.356,0,0,0-1.1,1.349,4.783,4.783,0,0,0-.228,1.588,8.522,8.522,0,0,0,.085,1.2c.043.367.087.746.1,1.146,0,.059,0,.11.007.156a.849.849,0,0,1-.26.76.816.816,0,0,1-.665.288,1.849,1.849,0,0,1-1.276-.792,1.974,1.974,0,0,1-.322-1.053A31.068,31.068,0,0,1,3.124,10.487c.375-1.255.54-1.5,1.779-1.793a13.115,13.115,0,0,1,4.068-.247,8.378,8.378,0,0,0,.875-.4c1.232-.616,2.91-1.454,3.831-.334a12.634,12.634,0,0,1,9.567,1.769,36.037,36.037,0,0,0,4.156.074c.195-.121.413-.252.606-.363l.056-.032a1.366,1.366,0,0,1,.494-.2c.444-.069.7.053.777.361a3.476,3.476,0,0,1,.065.939.97.97,0,0,1-.791.909l-.026,0-.025-.007c-.085-.022-.171-.042-.26-.062a3.127,3.127,0,0,1-.889-.3c-.633.016-1.155.007-1.659,0-.433-.007-.878-.015-1.394-.007.032.063.055.124.08.186a2.467,2.467,0,0,0,.112.256,6.534,6.534,0,0,1-.761,6.126c-.056.966-.027,1.957,0,2.915.014.492.029,1,.033,1.5v.086a1.448,1.448,0,0,1-.512,1.393,3.4,3.4,0,0,1-3.02.257,1.8,1.8,0,0,1-.564-.437c-.035-.036-.07-.072-.106-.106-.049,0-.1.006-.145.011a.95.95,0,0,1-.33-.006,1.375,1.375,0,0,1-.783-.571,1.769,1.769,0,0,1-.171-.361c-.023-.061-.047-.123-.076-.188l-.014-.031v-.034c0-.347-.006-.594-.013-.832-.005-.2-.011-.4-.012-.659a10.817,10.817,0,0,1-4-.092A17.56,17.56,0,0,1,14,23.135a.984.984,0,0,1-.5.813A3.748,3.748,0,0,1,11.5,24.439ZM9.531,23.121h.036l.03.114a1.106,1.106,0,0,0,.791.718,3.911,3.911,0,0,0,2.922-.259.687.687,0,0,0,.375-.6,17.162,17.162,0,0,0,.055-2.976l-.085-.024L14,19.405l.041.463a10.679,10.679,0,0,0,4.169.088l.181-.024v.182c0,.347.006.594.013.832s.012.473.013.807c.025.059.047.116.069.172a1.514,1.514,0,0,0,.139.3,1.057,1.057,0,0,0,.6.44.722.722,0,0,0,.216,0,1.888,1.888,0,0,1,.244-.013l.06,0,.044.041c.054.05.108.1.162.16a1.539,1.539,0,0,0,.46.366,3.1,3.1,0,0,0,2.712-.224c.388-.274.383-.65.377-1.127v-.087c0-.5-.018-1-.033-1.493-.029-.987-.059-2.007,0-3.008l0-.066.05-.044a6.185,6.185,0,0,0,.739-5.785,2.755,2.755,0,0,1-.126-.287.911.911,0,0,0-.2-.346l-.241-.259.353-.01c.654-.018,1.188-.009,1.706,0s1.045.018,1.691,0h.047l.04.025a2.716,2.716,0,0,0,.835.289c.082.019.163.037.242.057a.671.671,0,0,0,.471-.609,3.144,3.144,0,0,0-.058-.847c-.014-.061-.041-.175-.416-.117a1.064,1.064,0,0,0-.384.158l-.057.032c-.2.115-.431.254-.631.379L27.5,9.87h-.043a36.353,36.353,0,0,1-4.278-.077l-.042,0L23.1,9.767a12.347,12.347,0,0,0-9.461-1.725l-.1.018-.059-.08c-.747-1.02-2.334-.227-3.493.352a7.889,7.889,0,0,1-.95.43l-.032.01-.033,0a12.788,12.788,0,0,0-4,.236c-1.121.264-1.2.4-1.547,1.574a30.75,30.75,0,0,0-1,11.09,1.683,1.683,0,0,0,.258.884,1.551,1.551,0,0,0,1.033.666.493.493,0,0,0,.413-.179.552.552,0,0,0,.182-.532c0-.049-.006-.1-.007-.164-.011-.386-.055-.758-.1-1.118a8.743,8.743,0,0,1-.087-1.243,5.022,5.022,0,0,1,.251-1.7,2.67,2.67,0,0,1,1.24-1.509,1.4,1.4,0,0,1,1.444-.1c1.223.733,1.2,3.89,1.19,5.238v.167A1.4,1.4,0,0,0,9.28,22.7a.2.2,0,0,1,.15.045.4.4,0,0,1,.1.3C9.528,23.071,9.529,23.1,9.531,23.121Zm-.216-.1h0Z" style="fill:#373435"></path><path d="M18.572,19.946a4.782,4.782,0,0,0,.946-.189,11.582,11.582,0,0,1,.137,2.749,1.177,1.177,0,0,1-1.134-.663A8.774,8.774,0,0,1,18.572,19.946Z" style="fill:#6978ab"></path><path d="M19.622,22.666a1.33,1.33,0,0,1-1.242-.749l-.015-.028,0-.032a8.978,8.978,0,0,1,.052-1.932l.016-.124.124-.014a4.7,4.7,0,0,0,.915-.182l.164-.053.04.168a10.177,10.177,0,0,1,.147,2.484l-.008.459-.154,0Zm-.944-.87a1,1,0,0,0,.821.545l0-.144a10.985,10.985,0,0,0-.1-2.238,5.036,5.036,0,0,1-.683.13A8.609,8.609,0,0,0,18.677,21.8Z" style="fill:#373435"></path><path d="M4.052,22.683c-.225-1.474-.454-4.075.6-5.315a3.452,3.452,0,0,1,.27-.321c1.663-1.566,3.112-.219,3.505,1.515a27.314,27.314,0,0,1,.051,3.295,1.109,1.109,0,0,0,1.051.6c.153.316.112.551.286.76a2.5,2.5,0,0,0,2.7.694,8.441,8.441,0,0,0,.913-.454,10.14,10.14,0,0,0-.1-4.045c0-.184-.061-.306-.061-.49a.626.626,0,0,1,.311.138c-.2.734,2.556,1.239,5.771.352.036-.128-.026-.286.051-.332a.4.4,0,0,1,.337-.041c.015.235.02.464.036.7a4.654,4.654,0,0,0,.75.01.838.838,0,0,1-.6.214c.056,0-.031.107.02.117.148.036.429-.02.546.031-.219.128-.464.056-.612.2.036.78.056,1.617.087,2.4a2.591,2.591,0,0,0,3.311-.148,28.633,28.633,0,0,0-.1-4.7c-.117-.015-.235-.036-.352-.051,1.827-2.458,2.179-4.973.648-7.243-.015-.1-.082-.2-.1-.3,1.332-.051,2.7.087,4.036.036a6.478,6.478,0,0,0,1.112.311c.393-.138.464-1.229.077-1.107s-.6.367-1.015.52c-1.531,0-3.23-.061-4.76-.061a9.5,9.5,0,0,0-9-1.551,8.371,8.371,0,0,1,.26,6.427c-.087.286-1.408,1.122-.327.209,1.092-.928.408-7.375-.934-7.386a6.327,6.327,0,0,0-4.25,1.7c-.209-.224-.194-.133-.1-.449a9.863,9.863,0,0,0-3.4.3,1.428,1.428,0,0,0-1.3.949,33.949,33.949,0,0,0-1.2,11.094,4.574,4.574,0,0,0,.352,1.3c.6.658.924.469,1.123.122Z" style="fill:url(#a)"></path><path d="M6.446,10.422a2.187,2.187,0,0,0-1.063-.149.144.144,0,0,0-.153.1.2.2,0,0,0-.02.154c.031.087.036.082.112.1a.648.648,0,0,0,.3-.026.883.883,0,0,1,.746-.036c.112-.005.123-.051.087-.139Z" style="fill:#373435"></path><path d="M5.406,10.791a.566.566,0,0,1-.118-.012l-.013,0a.246.246,0,0,1-.217-.2.367.367,0,0,1,.031-.284.294.294,0,0,1,.283-.18,2.335,2.335,0,0,1,1.1.149h.082l.041.1a.237.237,0,0,1-.227.359H6.344l-.027-.008a.722.722,0,0,0-.62.022l-.018.011-.02.005A.989.989,0,0,1,5.406,10.791Zm-.044-.323a.5.5,0,0,0,.2-.02l.054-.027c-.07,0-.141,0-.213.011H5.377l-.006.012A.075.075,0,0,0,5.362,10.468Z" style="fill:#373435"></path><path d="M5.622,11.687a.549.549,0,0,1,.507-.311c.02-.128,0-.2-.164-.2a1.535,1.535,0,0,0-.578.51,1.051,1.051,0,0,0-.077.6.538.538,0,0,0,.2.352.666.666,0,0,0,.752-.031c.358-.209.716-.806.087-1.031a.963.963,0,0,0-.732.153c-.01.005-.015-.015,0-.041Z" style="fill:#373435"></path><path d="M5.816,12.906a.622.622,0,0,1-.408-.142.7.7,0,0,1-.256-.458,1.154,1.154,0,0,1,.1-.7,1.7,1.7,0,0,1,.635-.568l.035-.021H5.96a.338.338,0,0,1,.269.095.348.348,0,0,1,.058.289h0a.683.683,0,0,1,.564.524.975.975,0,0,1-.508.823A1.067,1.067,0,0,1,5.816,12.906ZM5.493,11.84a1.082,1.082,0,0,0-.024.432.38.38,0,0,0,.145.248c.193.161.506-.011.567-.047a.674.674,0,0,0,.352-.518c-.009-.1-.089-.172-.237-.225a.824.824,0,0,0-.593.138l-.013.007-.107.054-.088-.089Z" style="fill:#373435"></path><path d="M5.9,12.381a.4.4,0,0,0,.021.107.211.211,0,0,0,.021.046.215.215,0,0,1-.2.02c-.221-.1-.205-.41-.092-.578a.671.671,0,0,1,.529-.292c.118.061.154.118.092.133a.337.337,0,0,0-.1.036.183.183,0,0,0-.1.113c.051.015.077,0,.123.02v.159a.24.24,0,0,0-.159-.02c-.1.031-.139.174-.139.261Z" style="fill:#fefefe"></path><path d="M6.323,16.459A2.19,2.19,0,0,0,8,13.834a1.1,1.1,0,0,1-.511-.138c-.01-.066-.015-.133-.026-.2.414.2,1,.26.924-.373.056-.015.143-.02.2-.036-.02.444-.1.485-.373.674a3.01,3.01,0,0,1-.9,2.666.881.881,0,0,0,.036.414,1.233,1.233,0,0,0-1.026-.373Z" style="fill:#373435"></path><path d="M7.632,17.391l-.4-.442a1.081,1.081,0,0,0-.906-.32l-.162,0v-.28l.113-.045a2.02,2.02,0,0,0,1.584-2.327,1.028,1.028,0,0,1-.458-.147l-.062-.039L7.33,13.72c-.005-.035-.01-.07-.014-.105s-.007-.062-.012-.094l-.046-.3.273.132a.734.734,0,0,0,.625.08c.064-.045.088-.143.071-.291l-.015-.136.132-.036a.994.994,0,0,1,.119-.022.721.721,0,0,0,.08-.014l.212-.058-.01.219c-.021.456-.121.571-.361.742a3.172,3.172,0,0,1-.925,2.669.941.941,0,0,0,.035.252Zm-.7-1.008a1.2,1.2,0,0,1,.21.09.431.431,0,0,1,.021-.1l.011-.032.023-.025q.128-.137.237-.275A2.643,2.643,0,0,1,6.932,16.383Z" style="fill:#373435"></path><path d="M22.157,23.213c-.025-.377-.071-.708-.082-1.086-.025-.866-.683-1.055-.719-.189-.02.454,0,.882,0,1.31A2.244,2.244,0,0,0,22.157,23.213Z" style="fill:#8093d0"></path><path d="M21.739,23.32c-.1,0-.194-.006-.289-.012L21.3,23.3v-.05c0-.142,0-.283,0-.425,0-.286-.009-.582,0-.887.019-.453.2-.614.361-.614h0c.213,0,.447.283.463.8.006.231.026.442.046.665.013.136.025.274.035.418l0,.043-.041.012A1.523,1.523,0,0,1,21.739,23.32ZM21.41,23.2l.048,0a1.993,1.993,0,0,0,.643-.029c-.009-.128-.021-.251-.032-.372-.021-.225-.04-.437-.047-.672-.013-.431-.2-.7-.357-.7h0c-.108,0-.239.134-.255.512-.014.3-.009.6,0,.881C21.408,22.948,21.41,23.073,21.41,23.2Z" style="fill:#373435"></path><path d="M21.368,23.257a6.358,6.358,0,0,1-.081-1.317c.056-.8-.7-1.643-.751-.158a7.955,7.955,0,0,0,.051,1.3A5.155,5.155,0,0,0,21.368,23.257Z" style="fill:#8093d0"></path><path d="M21.429,23.321l-.069-.011a5.145,5.145,0,0,1-.79-.175l-.032-.011,0-.033a7.975,7.975,0,0,1-.051-1.31c.016-.479.1-.763.263-.845a.221.221,0,0,1,.234.023,1.2,1.2,0,0,1,.361.985A5.475,5.475,0,0,0,21.4,23.1Zm-.794-.277a5,5,0,0,0,.671.15l-.01-.083a5.645,5.645,0,0,1-.063-1.174,1.1,1.1,0,0,0-.313-.889.119.119,0,0,0-.126-.018c-.055.028-.185.159-.206.754A7.9,7.9,0,0,0,20.635,23.044Z" style="fill:#373435"></path><path d="M20.588,23.15l-.107-1.7c-.077-1.269-.587-1.121-.628-.076-.02.494.02.764-.026,1.259.24.163.49.484.761.51Z" style="fill:#8093d0"></path><path d="M20.583,23.2a1.1,1.1,0,0,1-.555-.331,2.5,2.5,0,0,0-.23-.188l-.026-.018,0-.031a6.217,6.217,0,0,0,.021-.72c0-.162,0-.329,0-.536.021-.533.162-.879.359-.881h0c.2,0,.338.357.374.956l.107,1.7h0v0l-.054,0Zm-.7-.589c.072.052.144.116.215.178a1.28,1.28,0,0,0,.432.293l-.1-1.624c-.038-.629-.181-.856-.268-.856h0c-.09,0-.233.249-.253.779-.009.2-.006.371,0,.531A6.444,6.444,0,0,1,19.883,22.609Z" style="fill:#373435"></path><path d="M11.865,24.028a7.005,7.005,0,0,0-.061-1.191c-.214-.92-.484-1.033-.8-.353v1.528a3.474,3.474,0,0,0,.862.01Z" style="fill:#8093d0"></path><path d="M11.542,24.1c-.166,0-.332-.015-.495-.03l-.1-.009,0-1.6c.153-.329.3-.482.448-.466.182.019.326.282.453.829l.01.087a6.605,6.605,0,0,1,.053,1.118h-.052l.007.046A2.073,2.073,0,0,1,11.542,24.1Zm-.486-.136h0a3.437,3.437,0,0,0,.757.013,6.638,6.638,0,0,0-.054-1.053l-.009-.081c-.146-.627-.288-.734-.359-.741-.055,0-.168.039-.335.395Z" style="fill:#373435"></path><path d="M10.3,23.776c.005-.586.01-.974.01-1.56.214-.862.433-.775.647.26.005.556.01.918.01,1.473a1.647,1.647,0,0,1-.673-.173Z" style="fill:#8093d0"></path><path d="M11.017,24.009l-.09-.01a1.627,1.627,0,0,1-.663-.177l-.175-.1h.154l0-.3c0-.41.007-.749.007-1.211l0-.013c.108-.434.214-.628.345-.628h0c.1,0,.241.105.4.89l0,.346c0,.385.007.7.007,1.139Zm-.667-.262a1.517,1.517,0,0,0,.561.142c0-.406,0-.711-.007-1.078l0-.335c-.157-.753-.277-.794-.3-.794s-.109.012-.241.54c0,.459,0,.8-.007,1.206Z" style="fill:#373435"></path><path d="M9.5,22.623c.031-.49.133-.985.163-1.475-.2-.97-.418-1.143-.647-.51-.01.628-.015,1.261-.025,1.889a.711.711,0,0,0,.51.1Z" style="fill:#8093d0"></path><path d="M9.373,22.7a.8.8,0,0,1-.348-.1l-.084-.038v-.035q.008-.471.013-.944t.013-.945l0-.017c.1-.287.206-.416.326-.408s.259.121.424.926v.014c-.015.247-.049.5-.082.741s-.066.49-.081.732v.046l-.042.009A.679.679,0,0,1,9.373,22.7Zm-.324-.2.02.009a.61.61,0,0,0,.385.082c.016-.235.048-.474.08-.705s.065-.486.081-.727c-.157-.763-.289-.831-.326-.834-.02,0-.1.017-.215.33q-.008.466-.013.935T9.049,22.492Z" style="fill:#373435"></path><path d="M19.021,22.468c.041-.521-.015-.955,0-1.465.015-.618.626-.439.652.128s.056.858.087,1.424a1.309,1.309,0,0,1-.733-.087Z" style="fill:#8093d0"></path><path d="M19.463,22.618a.922.922,0,0,1-.451-.1h-.044v-.057a7.342,7.342,0,0,0,.006-.836c-.006-.2-.013-.407-.006-.626.008-.322.167-.438.313-.439h0c.2,0,.427.215.442.566.015.289.03.5.044.721s.028.423.043.7l0,.054-.155.006C19.592,22.615,19.527,22.618,19.463,22.618Zm-.387-.184a1.1,1.1,0,0,0,.579.072l.048,0c-.014-.253-.027-.451-.04-.648-.014-.217-.028-.433-.044-.723s-.183-.465-.336-.465h0c-.125,0-.2.127-.208.336s0,.421.006.62A7.778,7.778,0,0,1,19.076,22.434Z" style="fill:#373435"></path><path d="M18.989,22.487c-.015-.382-.01-.841-.025-1.223.036-.525-.326-1.3-.468-.438a8.571,8.571,0,0,0-.081.963A4.066,4.066,0,0,0,18.989,22.487Z" style="fill:#b9c5ea"></path><path d="M19.046,22.595l-.089-.064A2.556,2.556,0,0,1,18.5,22c-.048-.067-.092-.128-.128-.174l-.013-.016v-.02c.007-.1.012-.2.016-.28a5.486,5.486,0,0,1,.066-.688c.018-.112.074-.452.253-.43.2.024.343.558.321.88.008.186.01.4.013.607s.005.42.013.61Zm-.578-.822c.035.045.075.1.119.162a3.567,3.567,0,0,0,.345.433c0-.158-.007-.327-.009-.491,0-.206-.005-.42-.013-.61.025-.372-.14-.763-.227-.773-.019-.006-.088.054-.136.341a5.4,5.4,0,0,0-.065.676C18.478,21.591,18.474,21.676,18.468,21.772Z" style="fill:#373435"></path><path d="M14.443,15.459c.26-1.24.515-2.48.775-3.725.041-.291.117-.551.423-.577h.372c.224,0,.352.133.372.4l-.076.551c.01.225.148.352.423.373.372.015.75.036,1.122.051.561.036.938.276.9.975-.117.617-.235,1.235-.352,1.847a.725.725,0,0,1-.474.648c-.168-.01-.357.01-.525,0-.291.015-.459-.092-.352-.475.107-.485.24-1.092.352-1.577.041-.577-.173-.607-.4-.648-.194-.026-.382,0-.576-.026-.286.041-.393.316-.474.623-.122.515-.25,1.031-.372,1.551-.056.281-.117.464-.326.551h-.622q-.352-.077-.2-.551Z" style="fill:#373435"></path><path d="M17.509,16.11c-.037,0-.073,0-.109,0a.468.468,0,0,1-.415-.137.511.511,0,0,1-.039-.473l.061-.278c.093-.422.2-.893.288-1.286.031-.465-.094-.488-.3-.526-.186-.025-.365,0-.565-.024-.2.036-.291.235-.373.542-.054.227-.11.458-.166.689-.069.286-.138.572-.206.86s-.123.514-.389.625l-.02.008-.666,0a.4.4,0,0,1-.276-.185.616.616,0,0,1,0-.5l.033-.1q.2-.969.4-1.939.172-.83.345-1.661c.028-.2.087-.625.519-.661h.381c.164,0,.445.064.478.5v.011l-.077.552c.007.113.054.242.324.262l.561.025.557.025a.928.928,0,0,1,1,1.087l0,.014c-.117.618-.235,1.235-.352,1.848a.829.829,0,0,1-.543.728l-.02.007h-.022c-.079,0-.164,0-.253,0C17.614,16.108,17.561,16.11,17.509,16.11Zm-.108-.216h.006c.079,0,.164,0,.253,0s.168,0,.25,0a.625.625,0,0,0,.385-.557q.176-.92.351-1.844c.031-.562-.208-.818-.8-.855l-.556-.025-.563-.026c-.44-.033-.518-.311-.525-.474V12.1l.076-.549c-.023-.256-.154-.289-.265-.289h-.372c-.184.016-.27.143-.318.485-.117.562-.232,1.115-.347,1.668q-.214,1.033-.43,2.064l-.04.193-.012-.012a.261.261,0,0,0,.023.151.187.187,0,0,0,.126.081h.587c.143-.068.192-.2.244-.466.069-.292.138-.579.207-.865q.084-.346.166-.691c.061-.228.172-.648.563-.7l.014,0,.015,0c.182.024.372,0,.576.026l.014,0c.286.052.519.145.476.759l0,.017c-.091.394-.2.868-.289,1.292l-.063.284c-.04.143-.04.241,0,.289s.157.061.243.057Z" style="fill:#fefefe"></path><path d="M9.624,16.894c.255-1.322.515-2.644.771-3.961a.426.426,0,0,1,.449-.449h2.348a1.231,1.231,0,0,1,1.107.623,1.587,1.587,0,0,1,.189.934,2.35,2.35,0,0,1-.694,1.465,2.186,2.186,0,0,1-1.148.5c-.4.01-.8.015-1.2.026-.23-.02-.459.041-.515.225-.071.25-.122.5-.194.745a.42.42,0,0,1-.265.23c-.23.005-.464.005-.694.01C9.532,17.246,9.583,17.1,9.624,16.894Zm1.638-2.266c.066-.347.148-.74.209-1.046a.452.452,0,0,1,.449-.3,1.825,1.825,0,0,1,.715.092.766.766,0,0,1,.383,1.082,1.437,1.437,0,0,1-.852.7,1.651,1.651,0,0,1-.51.051c-.439-.046-.475-.163-.4-.582Z" style="fill:#373435"></path><path d="M9.766,17.348a.283.283,0,0,1-.232-.085c-.076-.091-.05-.214-.023-.344l.009-.045q.211-1.092.425-2.184.172-.882.343-1.762a.5.5,0,0,1,.138-.377.559.559,0,0,1,.423-.173h2.343a1.327,1.327,0,0,1,1.2.681,1.693,1.693,0,0,1,.2.99,2.458,2.458,0,0,1-.724,1.532l-.012.011a2.288,2.288,0,0,1-1.2.521c-.206.006-.407.009-.607.013l-.6.013h-.012c-.161-.014-.364.016-.4.15s-.065.244-.1.367-.062.25-.1.377a.509.509,0,0,1-.326.3l-.019.008h-.02l-.345.005-.349.005Zm-.067-.22a.226.226,0,0,0,.076.007l.352-.005.322,0c.108-.048.17-.1.187-.154.035-.123.065-.245.1-.368s.062-.25.1-.376c.065-.214.3-.329.621-.3l.594-.013.6-.013a2.083,2.083,0,0,0,1.08-.474,2.246,2.246,0,0,0,.659-1.392,1.487,1.487,0,0,0-.178-.879,1.144,1.144,0,0,0-1.018-.564H10.844a.343.343,0,0,0-.263.107.285.285,0,0,0-.08.226l0,.015,0,.015q-.172.887-.346,1.777-.213,1.091-.425,2.184l-.01.047a.541.541,0,0,0-.02.166Zm2.052-1.812c-.035,0-.07,0-.106,0a.636.636,0,0,1-.458-.179c-.089-.119-.081-.277-.035-.528l.036-.2.007.007c.035-.179.073-.363.108-.536l.073-.343a.555.555,0,0,1,.552-.36,1.889,1.889,0,0,1,.745.1.806.806,0,0,1,.472.449.99.99,0,0,1-.03.776l-.007.013a1.536,1.536,0,0,1-.911.745A2.067,2.067,0,0,1,11.75,15.316Zm-.413-.512a.307.307,0,0,0,.021.2c.035.046.133.076.308.095a1.579,1.579,0,0,0,.476-.049,1.322,1.322,0,0,0,.781-.645.775.775,0,0,0,.025-.6.6.6,0,0,0-.351-.331,1.712,1.712,0,0,0-.674-.085.34.34,0,0,0-.35.23l-.061.3c-.048.236-.1.493-.145.729Z" style="fill:#fefefe"></path><path d="M18.545,16.894c.255-1.322.515-2.644.771-3.961a.426.426,0,0,1,.449-.449h2.348a1.231,1.231,0,0,1,1.107.623,1.587,1.587,0,0,1,.189.934,2.35,2.35,0,0,1-.694,1.465,2.186,2.186,0,0,1-1.148.5c-.4.01-.8.015-1.2.026-.23-.02-.459.041-.515.225-.071.25-.122.5-.194.745a.42.42,0,0,1-.265.23c-.23.005-.464.005-.694.01C18.453,17.246,18.5,17.1,18.545,16.894Zm1.638-2.266c.066-.347.148-.74.209-1.046a.452.452,0,0,1,.449-.3,1.825,1.825,0,0,1,.715.092.766.766,0,0,1,.383,1.082,1.437,1.437,0,0,1-.852.7,1.651,1.651,0,0,1-.51.051c-.439-.046-.475-.163-.4-.582Z" style="fill:#373435"></path><path d="M18.687,17.348a.284.284,0,0,1-.232-.085c-.076-.091-.05-.214-.023-.344l.009-.045q.21-1.089.423-2.176.173-.886.345-1.77a.5.5,0,0,1,.138-.377.559.559,0,0,1,.423-.173h2.343a1.327,1.327,0,0,1,1.2.681,1.694,1.694,0,0,1,.2.99,2.459,2.459,0,0,1-.724,1.532l-.012.011a2.288,2.288,0,0,1-1.2.521c-.206.006-.407.009-.607.013l-.6.013h-.012c-.162-.014-.364.016-.4.15s-.065.244-.1.366-.062.251-.1.377a.509.509,0,0,1-.326.3l-.019.008h-.02l-.345.005-.349.005Zm-.067-.22a.238.238,0,0,0,.076.007l.352-.005.322,0c.108-.048.17-.1.187-.154.035-.123.066-.246.1-.368s.062-.249.1-.375c.065-.214.3-.329.621-.3l.594-.013.6-.013a2.083,2.083,0,0,0,1.08-.474,2.246,2.246,0,0,0,.659-1.392,1.486,1.486,0,0,0-.178-.879,1.144,1.144,0,0,0-1.018-.564H19.765a.341.341,0,0,0-.263.107.285.285,0,0,0-.08.226l0,.015,0,.015q-.173.891-.347,1.785-.212,1.087-.423,2.176h0l-.01.047a.541.541,0,0,0-.02.166Zm2.052-1.812c-.035,0-.07,0-.106,0a.636.636,0,0,1-.458-.179c-.089-.119-.081-.277-.035-.528l.036-.2.007.007c.035-.18.073-.365.108-.539l.073-.341a.552.552,0,0,1,.552-.36,1.9,1.9,0,0,1,.745.1.806.806,0,0,1,.472.449.99.99,0,0,1-.03.776l-.007.013a1.536,1.536,0,0,1-.911.745A2.067,2.067,0,0,1,20.672,15.316Zm-.414-.511a.307.307,0,0,0,.021.2c.035.046.133.076.308.095a1.58,1.58,0,0,0,.476-.049,1.322,1.322,0,0,0,.781-.645.775.775,0,0,0,.025-.6.6.6,0,0,0-.351-.331,1.709,1.709,0,0,0-.674-.085.341.341,0,0,0-.35.23l-.061.3c-.048.237-.1.495-.145.731Z" style="fill:#fefefe"></path><path d="M3.425,22.906a1.615,1.615,0,0,1-.3-.393,1.41,1.41,0,0,1-.173-.735c-.26-4.433-.031-8.31,1.382-11.478.173-.388.2-.505.561-.684a7.429,7.429,0,0,1,3.452-.4c.036-.1.107-.2.076-.3a9.955,9.955,0,0,0-3.146.25c-.7.112-1.382.235-1.55,1.347-1.412,3.739-1.31,7.28-1.163,10.759a2.433,2.433,0,0,0,.112.74c.275.877.541.847.75.893Z" style="fill:#ebefff"></path><path d="M8.848,22.351c0-.923-.076-1.846-.076-2.773a5.413,5.413,0,0,0-.341-1.545,7.481,7.481,0,0,0-.7-1.025,7.387,7.387,0,0,1,.7,4.92C8.573,22.07,8.7,22.213,8.848,22.351Z" style="fill:#ebefff"></path><path d="M8.924,22.534l-.071-.027a1.536,1.536,0,0,1-.66-.542l-.069-.087h.065c.015-.331.009-.634,0-.928-.006-.31-.013-.63.005-.982l0-.059.059.009a.788.788,0,0,1,.69.6l0,.008v.008c-.005.344-.009.65-.013.955s-.008.622-.013.97Zm-.631-.614a1.519,1.519,0,0,0,.526.458c0-.316.008-.6.012-.891,0-.3.008-.607.013-.947a.672.672,0,0,0-.544-.505c-.014.324-.008.623,0,.913C8.3,21.255,8.31,21.572,8.293,21.92Z" style="fill:#373435"></path><path d="M10.252,23.657a1.022,1.022,0,0,1-.5-.423c-.036-1.648-.067-3.3-.1-4.949l.251.25a6.049,6.049,0,0,1,.077,1.051l.077.2A37.7,37.7,0,0,0,10.252,23.657Z" style="fill:#ebefff"></path><path d="M10.335,24.023,10.265,24a1.209,1.209,0,0,1-.673-.586L9.585,23.4V23.38c0-.549.01-1.117.01-1.673v-.014l.007-.012c.151-.275.281-.452.423-.424.111.022.236.151.32.935,0,.583-.01,1.177-.01,1.758Zm-.643-.65a1.124,1.124,0,0,0,.537.5c0-.557.005-1.124.01-1.674-.078-.729-.19-.829-.234-.838s-.13.047-.3.359C9.7,22.27,9.7,22.831,9.692,23.374Zm-.044.009h0Z" style="fill:#373435"></path><path d="M8.5,18.057a.708.708,0,0,0-.036-.25c.041.01.082.015.122.026l.647.526a.377.377,0,0,0,.2-.2.27.27,0,0,1,.214.1c.01.419-.02.832-.01,1.25a.356.356,0,0,1,.122.225,7.181,7.181,0,0,1,.8.077c.015.066.036.107.051.174a4.038,4.038,0,0,0-.9,0v.189a2.838,2.838,0,0,1,.7.051c.01.056.015.082.025.138a2.831,2.831,0,0,0-.749.01c.031,1.031.041,2.052,0,3.088-.082-.194-.239-.383-.326-.577a19.57,19.57,0,0,0,.061-3.976A2.746,2.746,0,0,0,8.5,18.057Z" style="fill:#373435"></path><path d="M9.544,23.524a1.979,1.979,0,0,0-.155-.274,2.414,2.414,0,0,1-.17-.3L9.2,22.909l.006-.045a19.407,19.407,0,0,0,.062-3.9,2.7,2.7,0,0,0-.852-.767l-.09-.058.02-.106a.343.343,0,0,0-.018-.113c-.007-.027-.013-.053-.018-.079l-.046-.245.242.06.052.011c.023,0,.047.009.07.015l.034.009.584.474a.156.156,0,0,0,.039-.057l.039-.1h.111a.427.427,0,0,1,.345.171l.027.039v.048c.005.213,0,.427-.005.633,0,.183-.009.372-.006.558a.572.572,0,0,1,.086.131c.166.007.33.029.49.049l.206.025.112.013.025.11a.73.73,0,0,0,.021.072c.01.031.021.063.03.1l.049.212-.217-.017-.039,0,.073.4-.211-.022a2.894,2.894,0,0,0-.569-.009c.032,1.14.03,2.082,0,2.954ZM9.53,22.86l.019.036q0-.108,0-.219Q9.542,22.769,9.53,22.86ZM9.315,18.5a1.989,1.989,0,0,1,.175.215c0-.115,0-.231,0-.346A.62.62,0,0,1,9.315,18.5Z" style="fill:#373435"></path><path d="M9.121,8.964a3.473,3.473,0,0,0,1.307-.449,5.948,5.948,0,0,1,2.593-.75,1.8,1.8,0,0,0-1.2-.1A7.176,7.176,0,0,0,9.121,8.964Z" style="fill:#ebefff"></path><path d="M14.114,8.41a10.412,10.412,0,0,1,6.65.3,9.77,9.77,0,0,0-6.624-.447C14.139,8.365,14.114,8.314,14.114,8.41Z" style="fill:#ebefff"></path></g></svg>
                </label>
              </div>
            </div>
            
          </div>
          <br>

          <div class="bio">
            <label for="bio" class="input-title">Carta de Apresentação</label><br>
            <textarea id="bio" name="apresentacao" placeholder="Fale um pouco sobre você, experiências, qualidades e como você pode colaborar com as equipes de desenvolvedores"  rows="10" cols="100" maxlength="1000" wrap="soft"></textarea>
          </div>

          <br>

          <div class="linkedin">
            <small class="input-title">LinkedIn:</small><br>
            <input type="url" name="linkedin" id="linkedin" placeholder="Coloque o link do seu perfil do LinkedIn">
          </div>

          <div class="github">
            <small class="input-title">Github:</small><br>
            <input type="url" name="github" id="github" placeholder="Coloque o link do seu Github">
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
    <script src = "js/script.js"></script>
</body>
</html>


