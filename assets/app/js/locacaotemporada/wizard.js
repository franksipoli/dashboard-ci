// Forms Demo
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    var form = $("#form-cadastro-locacao");
    form.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
        }
    });
        
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

        forceMoveForward: true,
        
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
            toggleFields();
            resizeJquerySteps();
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {

            form.validate().settings.ignore = ":disabled,:hidden,.required-before";
            
            var id = form.find("#nidcadimo").val();

            if (!form.valid()){
                resizeJquerySteps();
                return false;
            } else {

                var etapa = form.find("#etapa").val();
                // Fazer ajax para salvar o registro e jogar o ID como um parâmetro
                $.post(basedir+"/locacaotemporada/registerAjax", { 
                    params: form.serialize(),
                    id: id
                }, 
                function(response){
                    var boletos = response.boletos;
                    for (i in boletos){
                        $(".boletos").append("<li>Boleto com vencimento em "+boletos[i].data_vencimento+" no valor de R$"+boletos[i].valor+" - <a target='_blank' href='"+baseurl+"/boleto/boletocaixa?h="+boletos[i].chash+"'>Imprimir</a></li>");
                    }
                    if (response.success!==undefined && etapa == "geral"){
                        form.append('<input type="hidden" name="nidcadloc" id="nidcadloc" value="' + response.id + '">');                        
                    }
                    $(".imprimir-contrato").attr("href",basedir+"/locacaotemporada/contratos/"+response.id);
                    $(".imprimir-ficha").attr("href", basedir+"/locacaotemporada/inquilinos/"+response.id);
                }, "json");             
                
                /**
                Seta o campo etapa com base no index (aba) aberto.
                Etapa 0: Cadastro geral
                Etapa 1: Endereço
                */

                if (newIndex == 0){
                    form.find("#etapa").val("geral");
                } else if (newIndex == 1) {
                    form.find("#etapa").val("area");
                } else if (newIndex == 2) {
                    form.find("#etapa").val("permuta");
                } else if (newIndex == 3) {
                    form.find("#etapa").val("endereco");
                }

                return true;
            }
        
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {

            var id = $("#nidcadloc").val();

            alert("Locação cadastrada com sucesso!");

            document.location = basedir+"/locacaotemporada/contratos/"+id;

        }
    });
    
    // VERTICAL
    // ----------------------------------- 

    $('.select-select2').select2();
    
  });

})(window, document, window.jQuery);