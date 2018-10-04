<html>
<div>
    <div>
        <?php if(isset($error)):?>
            <div><?=$error?></div>
        <?php endif; ?>
        <form action="<?=base_url('recortar')?>" method="POST" enctype="multipart/form-data">
            <div>
                <label>Selecione uma imagem em formato jpg ou png</label>
                <input type="file" name="imagem" id="seleciona-imagem"/>
            </div>
    </div>
    <div>
        <p>Selecione uma imagem para recortar</p>
        <div id="imagem-box">
            <img src="" style="display:none;width:100%;" id="visualizacao_img" />
        </div>
        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="wcrop" name="wcrop" />
        <input type="hidden" id="hcrop" name="hcrop" />
        <input type="hidden" id="wvisualizacao" name="wvisualizacao" />
        <input type="hidden" id="hvisualizacao" name="hvisualizacao" />
        <input type="hidden" id="woriginal" name="woriginal" />
        <input type="hidden" id="horiginal" name="horiginal" />
        <div>
            <input type="submit" value="Recortar" id="recortar-imagem"/>
        </div>
        </form>
    </div>
</div>
</html>