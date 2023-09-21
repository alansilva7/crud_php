<?php 
    include('conexao.php');

    if (isset($_POST['confirmar'])) {
        $id = intval($_GET['id']);
        $sql_code = "DELETE FROM clientes WHERE id = '$id'";
        $sql_query = $conn->query($sql_code) or die($conn->$error);

    if ($sql_query) { ?>
        <h1>Cliente deletado com sucesso!</h1> 
        <p><a href="/crud/clientes.php"> Clique aqui</a> para voltar na lista de clientes.</p>   
    <?php
    die();
    } 
}   
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Cliente</title>
</head>
<body>

    <h1>Tem certeza que deseja deletar este cliente?</h1>
    <form action="" method="post">
        <a style="margin-right: 40px;" href="/crud/clientes.php">Não</a>
        <button type="submit" name="confirmar" value="1">Sim</button>
    </form>
</body>
</html>