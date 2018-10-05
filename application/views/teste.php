<html>
<head>
<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script src="<?=base_url('assets/jcrop/js/jquery.Jcrop.js')?>"></script>
    <link rel="stylesheet" href="<?=base_url('assets/css/plugins/jquery.Jcrop.css')?>" type="text/css" />
    <script src="<?=base_url('assets/js/scripts.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/ckfinder/ckfinder.js')?>"></script>
</head>
<div class="container" style="margin-top:50px; margin-bottom:50px;">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-md-offset-3">
			<?php if(isset($error)):?>
				<div class="alert alert-warning"><?=$error?></div>
			<?php endif; ?>
			<form action="<?=base_url('recortar')?>" method="POST" enctype="multipart/form-data">
				<div class="form-group">
					<label>Selecione uma imagem em formato jpg ou png</label>
					<input type="file" name="imagem" id="seleciona-imagem"/>
				</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-md-offset-3">
			<p class="alert alert-info" id="texto-informativo">Selecione uma imagem para recortar</p>
			<div id="imagem-box">
				<img src="" class="img-responsive hidden" id="visualizacao_img" />
			</div>
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="wcrop" name="wcrop" />
			<input type="hidden" id="hcrop" name="hcrop" />
			<input type="hidden" id="wvisualizacao" name="wvisualizacao" />
			<input type="hidden" id="hvisualizacao" name="hvisualizacao" />
			<input type="hidden" id="woriginal" name="woriginal" />
			<input type="hidden" id="horiginal" name="horiginal" />
			<div class="form-group text-center">
				<input type="submit" class="btn btn-success hidden" value="Recortar" id="recortar-imagem"/>
			</div>
			</form>
		</div>
	</div>
</div>
<textarea cols="80" id="edi" name="editor1" rows="10">
                            </textarea>
                            <script>

                                CKEDITOR.replace('edi');

                     </script> 
</html>