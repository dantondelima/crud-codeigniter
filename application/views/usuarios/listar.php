<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD CodeIgniter</title>
</head>
<body>
    <h1 style="text-align: center;margin-top:200px;">Lista de categorias</h1>
    <table class="table">
    <thead >
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Nascimento</th>
            <th>Categoria</th>
            <th>Subcategoria</th>
            <th>Imagem</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($usuarios as $usuario): ?>
            <tr>
                <td><?= $usuario['nome'] ?></td>
                <td><?= $usuario['email'] ?></td>
                <td><?= $usuario['data_nasc'] ?></td>
                <td><?= $usuario['categoria'] ?></td>
                <td><?= $usuario['subcategoria'] ?></td>
                <td><img src="<?= $usuario['imagem'] ?>" alt="thumb"></td>
                <td><a href="<?php echo base_url() . 'usuario/alterar/' . $usuario['id_usuario'] ?>">Editar</a></td>
                <td><a href="<?php echo base_url() . 'usuario/excluir/' . $usuario['id_usuario'] ?>">Excluir</a></td>
            </tr>
        <?php
            endforeach
        ?>
    </tbody>
    </table>
    
</body>
</html>