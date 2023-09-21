<?php 
    $host = 'localhost';
    $db = 'crud';
    $user = 'root';
    $password = '';

    try {
        $conn = new mysqli($host, $user, $password, $db);
        if ($conn->connect_errno) {
            die("Erro ao conectar no MySql ". $conn->connect_errno);
        } else {
            echo "CONEXÃO OK!";
        }
    } catch (Exception $e) {
        echo "ERROR: " .$e->getMessage();
    }

    function formatar_data($data) {
        return implode('/', array_reverse(explode('-', $data)));
    }

        
    function formatar_telefone($telefone) {
        $ddd = substr ($telefone, 0, 2);
        $parte1 = substr ($telefone, 2, 5);
        $parte2 = substr ($telefone, 7);
        return "($ddd) $parte1-$parte2";
    }
