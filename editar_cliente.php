<?php 
    include('conexao.php');
    $id = intval($_GET['id']);

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
                    $pedacoes = explode('/', $nascimento); 
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
                        $sql_code = "UPDATE clientes
                                     SET nome = '$nome',
                                         email = '$email',
                                         telefone = '$telefone',
                                         nascimento = '$nascimento'
                                     WHERE id = $id"; 
                        $conexao_ok = $conn->query($sql_code) or die($conn->error);
    
                        if ($conexao_ok) {
                            echo "<p><strong>Cliente atualizado  com sucesso</strong></p>";
                            unset($_POST);
                        }
                    }
           
                
            }


            $sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
            $query_cliente = $conn->query($sql_cliente) or die($conn->error);
            $cliente = $query_cliente->fetch_assoc();

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
            <input type="text" name="nome" value="<?php echo $cliente['nome']; ?>">
        </div>
        <br>
        <div>
            <label>E-mail: </label>
            <input type="email" name="email" value="<?php echo $cliente['email']; ?>">
        </div>
        <br>
        <div>
            <label>Telefone: </label>
            <input placeholder="(11) 99999-9999" type="text" name="telefone" value="<?php if(!empty($cliente['telefone'])) echo formatar_telefone($cliente['telefone']); ?>">
        </div>
        <br>
        <div>
            <label>Nascimento: </label>
            <input type="text" name="nascimento" value="<?php if(!empty($cliente['nascimento'])) echo formatar_data($cliente['nascimento']); ?>">
        </div>
        <br>
        <button type="submit">Salvar Cliente</button>
    </form>
</body>
</html>