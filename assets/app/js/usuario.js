jQuery(document).ready(function(){
	var $ = jQuery;
	$("#frmCadastroUsuario").validate({
		rules: {
		    senha: "required",
		    csenha: {
		      equalTo: "#senha"
		    }
		}
	});
})
