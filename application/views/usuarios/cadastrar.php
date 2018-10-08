<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adicionar</title>
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script src="<?=base_url('assets/jcrop/js/jquery.Jcrop.js')?>"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    
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
    <div class="row"> 
        <form method="post" action="<?=base_url('recorte')?>" enctype="multipart/form-data">
            <div class="col-md-4">
                <div>
                    <label>Nome:</label>
                    <input class="form-control" type="text" name="nome" required/>
                </div>
                <div>
                    <label>Email:</label>
                    <input class="form-control" type="text" name="email" required/>
                </div>
                <div>
                    <label>Data de Nascimento:</label>
                    <input class="form-control" type="text" id="datepicker" name="data_nasc" required/>
                </div>
                <div>
                    <label>Categoria:</label>
                    <div>
                    <select class="form-control" name="categoria" id="categoria" placeholder="Categoria">
                    </select> 
                    </div>
                </div>
                <div>
                    <label>Subcategoria:</label>
                    <div>
                    <select class="form-control" name="subcategoria" id="subcategoria" placeholder="Subcategoria">
                        <option value="">Selecione uma subcategoria</option>
                    </select> 
                    </div>
                </div>
                <div>
                    <input style="margin-top:10px" class="btn btn-primary" type="submit" value="Adicionar"/>
                </div>
            </div>
        </form>
    </div>
    <div class="crop-div">
    </div>
</body>
</html>