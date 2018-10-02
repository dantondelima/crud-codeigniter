<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adicionar</title>
</head>
<body>
    <h1>Cadastro de categoria</h1>
    <div class="row"> 
        <form method="post" action="<?=base_url('subcategoria/cadastrar')?>" enctype="multipart/form-data">
            <div class="col-md-4">
                <div>
                <label>Nome:</label>
                    <input class="form-control" type="text" name="categoria" value="<?=set_value('nome')?>" style="margin-bottom:15px" required/>
                </div>
                <div>
                    <div>
                        <select class="form-control" name="id_categoria" style="height:35px">
                            @foreach($categoria as $c)
                                <option>placeholder</option>
                            @endforeach
                        </select>   
                    </div>
                    <input style="margin-top:10px" class="btn btn-primary" type="submit" value="Adicionar"/>
                </div>
            </div>
        </form>
    </div>
</body>
</html>