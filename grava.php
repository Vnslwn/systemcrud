<?php
$nome = $_POST["nome"];
$email = $_POST["email"];
$id = $_POST["id"] ?? null;
$action = $_POST["action"] ?? 'add';
try {
    $pdo = new PDO('mysql:host=localhost;dbname=crudsever', 'root', Null);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($action === 'add') {


        $stmt = $pdo->prepare('INSERT INTO crudtable VALUES(:id, :nome, :email)');
        $stmt->execute(array(
            ':id' => Null,
            ':nome' => "$nome",
            ':email' => "$email"

        ));
        echo ("<script>alert('Registrasdo com sucesso.');location.href='index.php';</script>");
        //echo $stmt->rowCount();
    } else if ($action === "edit") {
        // Atualizar um registro existente
        if ($id) {
            $stmt = $pdo->prepare('UPDATE crudtable SET nome = :nome, email = :email WHERE id = :id');
            $stmt->execute(array(
                ':id' => $id,
                ':nome' => $nome,
                ':email' => $email
            ));
            echo ("<script>alert('Atualizado com sucesso.');location.href='index.php';</script>");
        } else {
            echo ("<script>alert('ID não fornecido para atualização.');location.href='index.php';</script>");
        }

    } else if ($action === 'delete') {
        // Excluir um registro
        if ($id) {
            $stmt = $pdo->prepare('DELETE FROM crudtable WHERE id = :id');
            $stmt->execute(array(
                ':id' => $id
            ));
            echo ("<script>alert('Excluído com sucesso.');location.href='index.php';</script>");
        } else {
            echo ("<script>alert('ID não fornecido para exclusão.');location.href='index.php';</script>");
        }

    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}