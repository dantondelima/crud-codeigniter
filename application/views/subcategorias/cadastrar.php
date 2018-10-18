<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adicionar</title>
</head>
<body>
    <script type="text/javascript">
        $.getJSON("<?= base_url().'subcategoria/categoria'?>", function(dados){
            if (dados.length > 0){
                var option = "<option value=''>Selecione uma categoria</option>"; 
                $.each(dados, function(i, obj){
                    option += "<option value='"+obj.id_categoria+"'>"+
                        obj.categoria+"</option>";
                });
            }
            $("#categoria").html(option).show();
        });
    </script>
    <h1>Cadastro de subcategoria</h1>
    <div class="row"> 
        <form method="post" action="<?=base_url('subcategoria/cadastrar')?>" enctype="multipart/form-data">
            <div class="col-md-4">
                <div>
                <label>Nome:</label>
                    <input class="form-control" type="text" name="subcategoria" value="<?=set_value('nome')?>" style="margin-bottom:15px" required/>
                </div>
                <div>
                    <div>
                    <select class="form-control" name="categoria_id" id="categoria" placeholder="Categoria">
                    </select> 
                    </div>
                    <input style="margin-top:10px" class="btn btn-primary" type="submit" value="Adicionar"/>
                </div>
            </div>
        </form>
    </div>
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