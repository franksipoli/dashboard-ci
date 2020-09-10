// Forms Demo
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    var form = $("#form-cadastro");
    form.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
        }
    });
    
    alert("TESTE");

    form.children("div").steps({
	    labels: {
	        cancel: "Cancelar",
	        current: "etapa atual:",
	        pagination: "Paginação",
	        finish: "Concluir",
	        next: "Próximo",
	        previous: "Anterior",
	        loading: "Carregando..."    
	    },
	    
        headerTag: "h4",
        
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        onInit: function (event, currentIndex){
        	toggleFields();
            if(currentIndex == 0){
				resizeJquerySteps();
        	}
        },
        onStepChanged: function(event, currentIndex, priorIndex){
            resizeJquerySteps();
        	toggleFields();
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            console.log("OI1");
            form.validate().settings.ignore = ":disabled,:hidden";
        	resizeJquerySteps();
            console.log("OI");
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            console.log("OI2");
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            alert("Submitted!");

            // Submit form
            $(this).submit();
        }
    });
    
    // VERTICAL
    // ----------------------------------- 

    $('.select-select2').select2();
    
  });

})(window, document, window.jQuery);
