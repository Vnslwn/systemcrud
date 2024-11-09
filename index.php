<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Sistema CRUD</title>
</head>

<body>
    <h1>Sistema CRUD</h1>

    <form id="crudForm" action="grava.php" method="post">
        <input type="hidden" id="recordId" name="id" value="" />
        <input type="hidden" id="actionType" name="action" value="add" />

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />

        <button type="submit" id="submitButton">Adicionar</button>
    </form>

    <table id="recordTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
      $pdo = new PDO('mysql:host=localhost;dbname=crudsever', 'root', null);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $consulta = $pdo->query("SELECT * FROM crudtable ORDER BY id desc;");
      while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        echo "
          <tr>
            <td>{$linha['id']}</td>
            <td>{$linha['nome']}</td>
            <td>{$linha['email']}</td>
            <td>
              <button onclick='editRecord({$linha['id']}, \"{$linha['nome']}\", \"{$linha['email']}\")'>Editar</button>
              <button onclick='deleteRecord({$linha['id']})'>Excluir</button>
            </td>
          </tr>
        ";
      }
      ?>
        </tbody>
    </table>

    <script>
    function editRecord(id, nome, email) {
        document.getElementById('recordId').value = id;
        document.getElementById('nome').value = nome;
        document.getElementById('email').value = email;
        document.getElementById('actionType').value = 'edit';
        document.getElementById('submitButton').textContent = 'Atualizar';
    }

    function deleteRecord(id) {
        if (confirm('Tem certeza que deseja excluir este registro?')) {
            document.getElementById('recordId').value = id;
            document.getElementById('actionType').value = 'delete';
            document.getElementById('crudForm').submit();
        }
    }
    </script>
</body>

</html>