<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD CodeIgniter</title>
    <script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript"> 
    $(document).ready(function (){
        carregar();
        $.getJSON("<?= base_url().'usuario/subcategoria/all'?>", function(dados){
            var option = "<option value=''>Subcategoria</option>"; 
            if (dados.length > 0){
                $.each(dados, function(i, obj){
                    option += "<option value='"+obj.subcategoria_id+"'>"+
                        obj.subcategoria_nome+'</option>';
                });
            }
            $("#subcategoriaSearch").html(option).show();
        });
        $.getJSON("<?= base_url().'usuario/categoria'?>", function(dados){
            var option = "<option value=''>Categoria</option>"; 
            if (dados.length > 0){
                $.each(dados, function(i, obj){
                    option += "<option value='"+obj.categoria_id+"'>"+
                        obj.categoria_nome+'</option>';
                });
            }
            $("#categoriaSearch").html(option).show();
        });
        $('#subcategoriaSearch').change(function(){
            $('#tabelaUsuario').DataTable().destroy();
            carregar();
        });
        $('#categoriaSearch').change(function(){
            $('#tabelaUsuario').DataTable().destroy();
            carregar();
        });
        function carregar(){
            $('#tabelaUsuario').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "order": [],
                    "ajax": {
                        "url": "<?= base_url().'usuario/pega_dados'?>",
                        "type": "POST",
                        "data": function(data)
                            {
                            	data.subcategoria = $('#subcategoriaSearch').val();
                            	data.categoria = $('#categoriaSearch').val();
                            }
                        },
                    "columnDefs": [ {
                        "targets": [ 4, 5, 6, 7 ],
                         "orderable": false
                    } ],
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
                "pageLength": 15
           });
        }
    });
</script>
</head>
<body>
    <h1 style="text-align: center;margin-top:200px;">Lista de usuários</h1>
    <table id="tabelaUsuario" class="table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Data</th>
            <th><select id="subcategoriaSearch" name="subcategoriaSearch" class="form-control">
                        <option value="">Subcategoria</option>
                </select></th>
            <th><select id="categoriaSearch" name="CategoriaSearch" class="form-control">
                        <option value="">Categoria</option>
                </select></th>
            <th>Imagem</th>    
            <th>Editar</th>
            <th>Deletar</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
    
</body>
</html>