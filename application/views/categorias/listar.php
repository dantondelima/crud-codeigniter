<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD CodeIgniter</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#myTable').DataTable();  
        });
    </script>
</head>
<body>
    <h1 style="text-align: center;margin-top:200px;">Lista de categorias</h1>
    <table class="table" id="myTable">
    <thead>
        <tr>
            <th>Categoria</th>
            <th>Editar</th>
            <th>Excluir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if( !empty($categorias) ) {
            foreach($categorias as $c): ?>
            <tr>
                <td><?= $c['categoria'] ?></td>
                <td><a href="<?php echo base_url() . 'categoria/alterar/' . $c['id_categoria'] ?>">Editar</a></td>
                <td><a href="<?php echo base_url() . 'categoria/excluir/' . $c['id_categoria'] ?>">Excluir</a></td>
            </tr>
        <?php
            endforeach;
        }
        ?>
    </tbody>
    </table>
    
</body>
</html>