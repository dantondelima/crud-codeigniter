$(document).ready(function(){

  $("#seleciona-imagem").on('change', function(){
    if (typeof (FileReader) != "undefined") {
      var image_holder = $("#imagem-box");
      image_holder.empty();

      var reader = new FileReader();
      reader.onload = function (e) {
          var image = $("<img />", {
              "src": e.target.result,
              "class": "thumb-image",
              "style": "width: 600px;"
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

  // Ao tentar clicar o botão recortar
  // verifica se foi definida alguma área de corte
  $('#recortar-imagem').click(function(){
    if (parseInt($('#wcrop').val())) return true;
    alert('Selecione a área de corte para continuar.');
    return false;
  });
})

// Faz a atualização das coordenadas em relação ao ponto de corte
// cada vez que esse é modificado
// É chamado nos eventos onSelect e onChange do jCrop
function atualizaCoordenadas(c)
{
  $('#x').val(c.x);
  $('#y').val(c.y);
  $('#wcrop').val(c.w);
  $('#hcrop').val(c.h);
};

// Faz a verificação e define o tamanho da imagem original
// e da imagem na área de visualização para o recorte
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
