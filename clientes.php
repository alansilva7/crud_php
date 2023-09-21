<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
</head>
<?php 

    include('conexao.php');

    // SELECT * FROM faz a busca no MySql.
    $sql_clientes = "SELECT * FROM clientes";

    // query para consulta no sistema.
    $query_clientes = $conn->query($sql_clientes) or die($conn->error);

    // num_rows - retorna quantas linhas tem na pesquisa do mysqli.
    $num_clientes = $query_clientes->num_rows;

?>

<body>
    <h1>Lista de Clientes</h1>
   <button><a href="/crud/cadastro_de_clientes.php">Cadastrar</a></button>
    <p>Estes são os clientes cadastrados no seu sistema: </p>
    <table border="1" cellpadding="10">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Nascimento</th>
            <th>Data</th>
            <th>Ações</th>
        </thead>
        <tbody>
            <!-- tr>td*7 cria 7 linhas de td -->
            <?php if($num_clientes == 0) { ?>
            <tr>
                <td colspan="7">Nenhum cliente cadastrado</td>
            </tr>
            <?php } else {
                    while ($cliente = $query_clientes->fetch_assoc()) {
                    
                        $telefone = "Não informado!";
                        if (!empty ($cliente['telefone'])) {
                           $telefone = formatar_telefone($cliente['telefone']);
                        }

                        $nascimento = "Não infomado!";
                        if (!empty($cliente['nascimento'])) {
                            $nascimento = formatar_data($cliente['nascimento']);
                        }
                        // strtotime só funciona com datas em inglês, quando a gente envia datas para o banco de dados, usa-se o padrão BR, convertendo usando explode, implode e array_reverse.
                        $data_cadastro = date("d/m/Y H:i", strtotime($cliente['data'])); 
                ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><?php echo $cliente['nome'];?></td>
                    <td><?php echo $cliente['email'];?></td>
                    <td><?php echo $telefone;?></td>
                    <td><?php echo $nascimento;?></td>
                    <td><?php echo $data_cadastro;?></td>
                    <td>    
                        <a href="editar_cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a>
                        <a href="deletar_cliente.php?id=<?php echo $cliente['id']; ?>">Deletar</a>
                    </td>
                </tr>
                <?php
                    }
                } ?>
        </tbody>
    </table>
</body>
</html>