<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD CodeIgniter</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        $(document).ready(function(){
           var dataTable = $('#myTable').DataTable({
           "processing": true,
           "serverSide": true,
           "order": [],
           "ajax": {
               "url": "<?= base_url().'subcategoria/pega_dados'?>",
               "type": "POST"
           },
           "columnsDefs": [
                {
                    "target": [3, 4],
                    "orderable":false
                }
           ],
           "language": {
                "zeroRecords": "Nada encontrado - desculpe",
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponivel",
                "infoFiltered": "(filtrado do total de _MAX_ registros)",
                "paginate": {
                    "first":      "Primeira",
                    "last":       "Ultima",
                    "next":       "Proxima",
                    "previous":   "Anterior"
                },
                "search":         "Pesquisar:",
                "loadingRecords": "Carregando...",
                "processing":     "Processando..."
        },
            "lengthChange": false,
            "pageLength": 5
        }); 
    });
    </script>
</head>
<body>
    <h1 style="text-align: center;margin-top:200px;">Lista de subcategorias</h1>
    <table class="table" id="myTable">
    <thead>
        <tr>
            <th>Subcategoria</th>
            <th>Categoria</th>
            <th>Editar</th>
            <th>Excluir</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
    </table>
    <?php if ($this->session->flashdata('error') == TRUE): ?>
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><?php echo $this->session->flashdata('error'); ?></strong>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('success') == TRUE): ?>
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><?php echo $this->session->flashdata('success'); ?></strong>
    </div>
<?php endif;?>
</body>
</html>