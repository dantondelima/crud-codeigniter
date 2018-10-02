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
            <th>Categoria</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($categorias as $c): ?>
            <tr>
                <td><?= $c['subcategoria'] ?></td>
                <td><a href="<?php echo base_url() . 'subcategoria/alterar/' . $c['id_subcategoria'] ?>">Editar</a></td>
                <td><a href="<?php echo base_url() . 'subcategoria/excluir/' . $c['id_subcategoria'] ?>">Excluir</a></td>
            </tr>
        <?php
            endforeach
        ?>
    </tbody>
    </table>
    
</body>
</html>