$(document).ready(function(){
  $("#seleciona-imagem").on('change', function () {
    $('.img').remove();
  if (typeof (FileReader) != "undefined") {
      var image_holder = $("#imagem-box");
      image_holder.empty();

      var reader = new FileReader();
      reader.onload = function (e) {
          var image = $("<img />", {
              "src": e.target.result,
              "class": "thumb-image"
          }).appendTo(image_holder);
          image.Jcrop({
              onChange: atualizaCoordenadas,
              onSelect: atualizaCoordenadas,
          });
          defineTamanhoImagem(e.target.result, image);
      }
      image_holder.show();
      reader.readAsDataURL($(this)[0].files[0]);
  } else{
      alert("Este navegador nao suporta FileReader.");
  }
});

$('#recortar-imagem').click(function(){
  if (parseInt($('#wcrop').val())) return true;
  alert('Selecione a área de corte para continuar.');
  return false;
});
})

function atualizaCoordenadas(c)
{
  $('#x').val(c.x);
  $('#y').val(c.y);
  $('#wcrop').val(c.w);
  $('#hcrop').val(c.h);
};

function defineTamanhoImagem(imgOriginal, imgVisualizacao) {
var image = new Image();
image.src = imgOriginal;

image.onload = function() {
  $('#wvisualizacao').val(imgVisualizacao.width());
  $('#hvisualizacao').val(imgVisualizacao.height());
  $('#woriginal').val(this.width);
  $('#horiginal').val(this.height);
};
}