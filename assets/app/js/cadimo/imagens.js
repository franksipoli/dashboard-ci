function setarPosicoes(){
	var $ = jQuery;
	$.post(baseurl + "/cadimo/imovel/ordenar", {
		posicoes: $("#frmOrdemImagens").serialize()
	}, function(response){
		console.log(response);
	}, "json");
}
function setarBotaoRemover(){
	var $ = jQuery;
	$(".removerFoto").unbind("click").click(function(){
		if (confirm("Deseja realmente excluir esta foto?")){
            var id = $(this).attr("data-id");
    		$(this).closest(".imovel_foto").fadeOut("fast", function(){
    			$(this).remove();
    			$.get(baseurl + '/cadimo/imovel/removerFoto', {
    				nidtagimi: id
    			});
    		})
        }
		return false;
	}
)}
jQuery(function() {
	setarBotaoRemover();
    var $ = jQuery;
    $("#imagens").sortable({
    	items: "> div",
    	update: function( event, ui ) {
    		setarPosicoes();
    	}
    });
    console.log($("#frmDados").serialize());
    $('#file_upload').uploadify({
        'swf'      : baseurl + '/assets/app/js/uploadify.swf',
        'fileTypeExts' : '*.jpg',
        'uploader' : baseurl + '/cadimo/imovel/uploadFoto',
        'buttonText' : 'Buscar Imagens',
        'formData'      : {'nidcadimo' : $("#nidcadimo").val(), 'relacionados': $("#frmDados").serialize() },
        'onUploadSuccess' : function(file, data, response) {
            console.log(response);
            var obj = jQuery.parseJSON(data);
            for (i in obj){
            	$("#imagens").append('<div class="col-xs-12 col-sm-2 imovel_foto"><div class="form-group"><a href="#" data-id="'+obj[i].id+'" class="removerFoto"><i class="fa fa-times"></i></a><input type="hidden" name="ordem[]" value="'+obj[i].id+'"><img src="'+baseurl+'/'+obj[i].url+'" class="img-responsive"><label><input type="checkbox" name="enviar_site['+obj[i].id+']" value="1"> Enviar para o site</label></div></div>');
            	setarPosicoes();
            	setarBotaoRemover();
            }
        },
        'onUploadError' : function(file, errorCode, errorMsg, errorString) {
            alert('Houve um erro no upload da foto. Procure o administrador do sistema.');
        }
    });
});