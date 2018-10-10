<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adicionar</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <link rel="stylesheet" href="<?=base_url('assets/css/plugins/jquery.Jcrop.css')?>" type="text/css" />
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="<?=base_url('assets/jcrop/js/jquery.Jcrop.js')?>"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <script src="<?=base_url('assets/js/scripts.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>

    
    <script>
    $( function() {
        $(document).ready(function(){
        $( "#datepicker" ).datepicker({
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
        });
    });
    
      
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

        $("#categoria").change(function(e){
            

            var categoria = $("#categoria").val();
            $.getJSON("<?= base_url().'usuario/subcategoria/'?>"+categoria, function(dados){
                var option = "<option value=''>Selecione uma subcategoria</option>"; 
                if(dados.length > 0){
                    $.each(dados, function(i, obj){
                        option += "<option value='"+obj.id_subcategoria+"'>"+obj.subcategoria+'</option>';
                    })
                } else{
                    Reset();
                }
                $('#subcategoria').html(option).show();
            })
        }); 

        function Reset(){
            $('#subcategoria').empty().append('<option>Selecione uma subcategoria</option>>');
        }   
        });
        
    </script>
</head>
<body>
    <h1>Cadastro de usuário</h1>
    <div class="row col-md-10 center-block"> 
        <form method="post" action="<?=base_url('usuario/cadastrar')?>" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Nome:</label>
                    <input class="form-control" type="text" name="nome" required/>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input class="form-control" type="text" name="email" required/>
                </div>
                <div class="form-group">
                    <label>Data de Nascimento:</label>
                    <input class="form-control" type="text" id="datepicker" name="data_nasc" required/>
                </div>
                <div class="form-group">
                    <label>Categoria:</label>
                    <div>
                    <select class="form-control" name="categoria" id="categoria" placeholder="Categoria">
                    </select> 
                    </div>
                </div>
                <div class="form-group">
                    <label>Subcategoria:</label>
                    <div>
                    <select class="form-control" name="subcategoria" id="subcategoria" placeholder="Subcategoria">
                        <option value="">Selecione uma subcategoria</option>
                    </select> 
                    </div>
                </div>
    </div>
    <div class="crop-div" style="margin-left:30px;">
        <div class="row">
		<div class="">
			<?php if(isset($error)):?>
				<div class="alert alert-warning"><?=$error?></div>
			<?php endif; ?>
				<div class="form-group">
					<label class="col-md-8 alert alert-info img">Selecione uma imagem</label>
					<input type="file" name="imagem" id="seleciona-imagem"/>
					<div id="imagem-box">
					</div>
				</div>
		</div>
		<div class="col-md-12">			
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="wcrop" name="wcrop" />
			<input type="hidden" id="hcrop" name="hcrop" />
			<input type="hidden" id="wvisualizacao" name="wvisualizacao" />
			<input type="hidden" id="hvisualizacao" name="hvisualizacao" />
			<input type="hidden" id="woriginal" name="woriginal" />
			<input type="hidden" id="horiginal" name="horiginal" />

			<textarea cols="80" id="edi" name="desc" rows="5"></textarea>
    </div>
            <div>
            <input class="btn btn-primary btn-block" id="recortar-imagem" style="margin-bottom:45px;margin-top:15px;" type="submit" value="Cadastrar"/>
                </div>
            </div>
        </form>
    <script>
	CKEDITOR.replace('edi');
</script> 
</body>
</html>