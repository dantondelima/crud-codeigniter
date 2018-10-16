<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <table>
            <tr><th>Nome</th>               <td><?= $nome ?></td></tr>
            <tr><th>Email</th>              <td><?= $email ?></td></tr>
            <tr><th>Data de Nascimento</th> <td><?= $data ?></td></tr>
            <tr><th>Categoria</th>          <td><?= $categoria ?></td></tr>
            <tr><th>Subcategoria</th>       <td><?= $subcategoria ?></td></tr>
        </table>
        <img align="center" src="cid:<?= $imagem ?>" style="width: 100px"/>
        <br/>
        <br/>
        <div class="container-fluid">
            <?= $descricao ?>
        </div>
    </body>
</html>