<?php 
    include('conexao.php');
    //  Verifica se a variável é definida.
    // if (isset($_POST)) {
    //     var_dump($_POST);
    // }
 
    //  Conta os elementos de um array, ou propriedades em um objeto.
    // if (count($_POST) > 0) {
    //     //  var_dump mostra as informações da variavel.
    //     var_dump($_POST);
    // }

    function limpar_texto($str){ 
        return preg_replace("/[^0-9]/", "", $str); 
    }
        
        try {
            $erro = false;

            if (count($_POST) > 0) {
        
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $telefone = $_POST['telefone'];
                $nascimento = $_POST['nascimento'];
        
                if (empty($nome)) {
                    $erro = "Preencha o nome";
                }
        
                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $erro = "Preencha o e-mail";
                }
        
                if (!empty($nascimento)) {
                    //  vai retornar um array(28,02,1994).
                    //  explode() - explode o array em pedaços.
                    //  array_reserse() - reverte a ordem do array.
                    //  implode - junta o array novamente.
                    //  ex: 07/05/1997 mudou para 1997/05/07. -> padrão americano usado no MySql.
                    // $pedacoes = implode('-', array_reverse(explode('/'. $nascimento)));
                    
                    $pedacoes = explode('/', $nascimento); // criou um array de ('07/05/1997') para ->(07,05,1997).
                    // if(count($pedacoes)) == 3 - verifica se o array possui 3 elementos.
                    if (count($pedacoes) == 3) {
                        $nascimento = implode('-', array_reverse($pedacoes));
                    } else {
                        $erro = "A data deve seguir o padrão dia/mês/ano";
                    } 
                }
        
                if (!empty($telefone)) {
                    $telefone = limpar_texto($telefone);
                    if (strlen($telefone) != 11) {
                        $erro = "O telefone deve ser preenchido no padrão (11) 99999-9999";
                    }
                }
                
                if ($erro) {
                    echo "<p><strong>ERRO: $erro</strong></p>";
                } else {
                    $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data) VALUES ('$nome', '$email', '$telefone', '$nascimento', NOW())";
                    $conexao_ok = $conn->query($sql_code) or die($conn->error);

                    if ($conexao_ok) {
                        echo "<p><strong>Cliente cadastrado com sucesso</strong></p>";
                        unset($_POST);
                    }
                }
        
            }
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage();
        } 

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cadastro</title>
</head>
<body>
    <br>
    <br>
    <a href="/crud/clientes.php">voltar para a lista.</a>
    <br>
    <br>
    <form action="" method="post">
        <div>
            <label>Nome: </label>
            <input type="text" name="nome" value="<?php if(isset($_POST['nome'])) echo($_POST['nome']);?>">
        </div>
        <br>
        <div>
            <label>E-mail: </label>
            <input type="email" name="email" value="<?php if(isset($_POST['email'])) echo($_POST['email']);?>">
        </div>
        <br>
        <div>
            <label>Telefone: </label>
            <input placeholder="(11) 99999-9999" type="text" name="telefone" value="<?php if(isset($_POST['telefone'])) echo($_POST['telefone']);?>">
        </div>
        <br>
        <div>
            <label>Nascimento: </label>
            <input type="text" name="nascimento" value="<?php if(isset($_POST['nascimento'])) echo($_POST['nascimento']);?>">
        </div>
        <br>
        <button type="submit">Salvar Cliente</button>
    </form>
</body>
</html>