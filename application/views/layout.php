<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<? echo base_url('includes/bootstrap/css/bootstrap.min.css') ?>">
    <!-- Latest compiled and minified JavaScript -->
    <script src="<? echo base_url('includes/bootstrap/js/bootstrap.min.js') ?>"></script>
    <title>CRUD Codeigniter</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include_once 'navbar.php'; ?>
</head>
<body>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container-fluid">
         <div class="row"> 
            <div class="nav">
                <div class="nav-side-menu col-md-2">
                    <div class="brand">CRUD Codeigniter</div>
                    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

                        <div class="menu-list">

                            <ul id="menu-content" class="menu-content collapse out">
                                <li>
                                    <a href="<?= base_url()?>"><i class="fa fa-home fa-lg"></i>Home</a>
                                </li>
                                <li  data-toggle="collapse" data-target="#users" class="collapsed active">
                                  <a href="#"><i class="fa fa-users fa-lg"></i> Usuarios <span class="arrow"></span></a>
                                </li>
                                <ul class="sub-menu collapse" id="users">
                                    <!-- class="active" no li -->
                                    <li><a href="<?=base_url().'usuario/cadastrar'?>" id="formCadastro">Cadastrar Usuario</a></li>
                                    <li><a href="<?=base_url().'usuario'?>">Listar Usuarios</a></li>
                                </ul>
                                <li data-toggle="collapse" data-target="#categorias" class="collapsed">
                                  <a href="#"><i class="fa fa-bars fa-lg"></i> Categorias <span class="arrow"></span></a>
                                </li>  
                                <ul class="sub-menu collapse" id="categorias">
                                    <li><a href="<?=base_url().'categoria/cadastro'?>">Cadastrar Categoria</a></li>
                                    <li><a href="<?=base_url().'categoria'?>">Listar Categorias</a></li>
                                </ul>


                                <li data-toggle="collapse" data-target="#new" class="collapsed">
                                  <a href="#"><i class="fa fa-bars fa-lg"></i> Subcategorias <span class="arrow"></span></a>
                                </li>
                                <ul class="sub-menu collapse" id="new">
                                    <li><a href="subcategoria/cadastro">Cadastrar subcategoria</a></li>
                                    <li><a href="subcategoria">Listar subcategorias</a></li>
                                </ul>
                                 <li>
                                  <a href="#"><i class="fa fa-info-circle fa-lg"></i> Sobre</a>
                                  </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                <div style="margin-top: 10px; margin-left: 300px; margin-bottom: 10px">
                    <?php echo $contents; ?>
                </div>
        </div>    
    </body>
</html>