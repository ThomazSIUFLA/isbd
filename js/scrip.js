$("#busca").keyup(function(){
    var valor = $(this).val();
    if(valor){
      $('#tabela').hide();
    }
    var busca = $('#busca').val();
    $.post('../controller/buscaLivros.php', {busca: busca}, function(data){
      $('#resultado').html(data);
    });
  });