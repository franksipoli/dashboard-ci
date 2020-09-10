  function verificarDatasMenoresInicioLocacao(){
    var $ = jQuery;
    var tem_maior = false;
    var i = 
      $(".parcela-item").not('[data-parcela=0]').each(function(){
        var data = $(this).find(".data-vencimento").val();
        if (data == "" || $.datepicker.parseDate('dd/mm/yy', data) > $.datepicker.parseDate('dd/mm/yy', $('#data_inicial').val())){
          $(this).addClass('has-error');
          tem_maior = true;
        } else {
          $(this).removeClass('has-error');
        }
      })
      if (tem_maior){
        $(".actions a[href=#next]").hide();
        console.log('Esconde, tem data maior');
      } else {
        $(".actions a[href=#next]").show();
        console.log('Mostra, não tem data maior');
      }
  }

jQuery(document).ready(function(){

  setInterval(function(){
    verificarDatasMenoresInicioLocacao()
  }, 500);

  locacaotemporada_autocomplete();
  if ($("#imovelid").val()){ 
    $("#imovel").attr("readonly", "readonly").after('<a href="#" class="resetarAutocompleteImovel btn btn-danger btn-xs">[X]</a>');
    resetarAutocompleteImovel();
    resizeJquerySteps();
  }
    $("#data_inicial").datepicker({
      numberOfMonths: 1,
      dateFormat: 'dd/mm/yy',
      dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
      dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      nextText: 'Próximo',
      minDate: 0,
      prevText: 'Anterior',
      onClose: function( selectedDate ) {
        $( "#data_final" ).datepicker( "option", "minDate", selectedDate );
      }
  });
    $("#data_final").datepicker({
      numberOfMonths: 1,
      dateFormat: 'dd/mm/yy',
      dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
      dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      nextText: 'Próximo',
      prevText: 'Anterior',
      onClose: function( selectedDate ) {
        $( "#data_inicial" ).datepicker( "option", "maxDate", selectedDate );
        calcularDatas();
      }
  });

  $("#inputTaxaAdministrativa").blur(function(){
    calcularDatas();
  })

  $("#quantidade_parcelas").change(function(){
    reloadParcelas();
  })

  $("#btnAtualizarValores").click(function(){
    calcularDatas();
    return false;
  })

  if ($("#data_inicial").val() && $("#data_final").val()){
    calcularDatas();
  }

  reloadParcelas();

})

function reloadParcelas(){

  var quantidade = parseInt($("#quantidade_parcelas").val());

  var parcelas_current = $(".parcela-item").not("[data-parcela=0]").length;

  if (quantidade > parcelas_current){

    for (i=parcelas_current+1; i<=quantidade; i++){
      var item = $(".parcela-item[data-parcela=0]").clone();
      var parcela = parseInt(item.attr("data-parcela"));
      item.find("label.numero-parcela").html("Parcela "+i);
      item.attr("data-parcela", i);
      item.removeClass("hidden");
      if (parcelas_current == 0 && quantidade == 1){
        item.find(".data-vencimento").val($("#data_hoje").val()); 
      }
      $(".parcela-item").last().after(item);
      resizeJquerySteps();      
    }

  } else {

    for (i=parcelas_current; i>quantidade; i--){
      $(".parcela-item[data-parcela="+i+"]").remove();
    }

  }

  calcularDatas();

  $(".parcela-item .data-vencimento").removeClass('hasDatepicker').removeClass('valid').removeAttr('id').datepicker('destroy');

  $(".parcela-item .data-vencimento").datepicker({
      numberOfMonths: 1,
      dateFormat: 'dd/mm/yy',
      dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
      dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      nextText: 'Próximo',
      prevText: 'Anterior'
    });

  $(".parcela-item .data-vencimento").unbind("change").change(function(){
    calcularDatas();
    $(this).closest(".parcela-item").next(".parcela-item").find(".data-vencimento").datepicker('option', 'minDate', $.datepicker.parseDate('dd/mm/yy', $(this).val()));
  })

}

function calcularDatas(){
  $(".actions a[href=#next]").hide();
  console.log('Esconde');
  var data_inicial = $("#data_inicial").val();
  var data_final = $("#data_final").val();
  var taxa_administrativa = $("#inputTaxaAdministrativa").val();
  if (!data_inicial || !data_final){
    alert("É obrigatório selecionar um período de datas");
    return false;
  }
  $.post(basedir+"/locacaotemporada/calcularDatas", { 
      data_inicial: data_inicial,
      data_final: data_final,
      taxa_administrativa: taxa_administrativa,
      nidcadimo: $("#imovelid").val()
  }, function(response){
      $("#inputTaxaAdministrativa").val(parseFloat(response.taxa_administrativa).toFixed(2));
      $("#inputValorTotal").val(parseFloat(response.valor_total).toFixed(2));
      $("#descValorTotal").html("R$" + parseFloat(response.valor_diarias).toFixed(2) + " (Diárias) + R$" + parseFloat(response.taxa_administrativa).toFixed(2) + " (Taxa administrativa)");
      $("#inputValorTotal").closest(".form-group").show();
      var quantidade_parcelas = parseInt($("#quantidade_parcelas").val());
      if (quantidade_parcelas == 1){
        $(".parcela-item[data-parcela=1] input.valor").val(response.valor_total.toFixed(2));
      } else {
        /* Calcula a quantidade de valores já fixados */
        var valor_fixado = 0;
        var quantidade_parcelas_fixadas = $(".parcela-item:not([data-parcela=0]) .fixar-valor:checked").length;
        $(".parcela-item:not([data-parcela=0]) .fixar-valor:checked").each(function(){
          if (isNaN(parseFloat($(this).closest(".parcela-item").find(".valor").first().val()))){
            $(this).closest(".parcela-item").find(".valor").first().val("0.00");
          } else {
            valor_fixado += parseFloat($(this).closest(".parcela-item").find(".valor").first().val());
          }
        });
        if (valor_fixado > response.valor_total){
          alert("O valor já fixado é maior do que o valor total");
        } else {
          var valor_dividir = response.valor_total - valor_fixado;
          $(".parcela-item:not([data-parcela=0]) .fixar-valor:not(:checked)").each(function(){
            $(this).closest(".parcela-item").find(".valor").first().val(parseFloat(valor_dividir / (quantidade_parcelas - quantidade_parcelas_fixadas)).toFixed(2));
          })
        }
      }
      
      /* Verificar se o total é igual à soma das parcelas */
      var valor_total_soma = 0;
      $(".parcela-item").each(function(){
        var valor_parcela = parseFloat($(this).find(".valor").val());
        if (!isNaN(valor_parcela)){
          valor_total_soma += valor_parcela;
        }
      })
      valor_total_soma = valor_total_soma.toFixed(2);
      if (valor_total_soma != parseFloat($("#inputValorTotal").val()).toFixed(2) && valor_total_soma+0.01 != parseFloat($("#inputValorTotal").val()).toFixed(2) && valor_total_soma-0.01 != parseFloat($("#inputValorTotal").val()).toFixed(2)){
          alert("O valor somado das parcelas está diferente do valor total da locação. Valor somado: R$"+valor_total_soma+" / Valor total: R$"+parseFloat($("#inputValorTotal").val()));
          $(".actions a[href=#next]").hide();
          console.log('Esconde - Parcelas diferentes');
      } else {
        $(".actions a[href=#next]").show();
        console.log('Mostra - Parcelas iguais');
      }
      updateDescricaoPagamento();
  }, "json");
}

function updateDescricaoPagamento(){
  var i = 1;
  var quantidade_parcelas = $("#quantidade_parcelas").val();
  $("#infoPagamento").val("");
  $(".parcela-item:not([data-parcela=0])").each(function(){
    var valor = parseFloat($(this).find(".valor").val()).toFixed(2).replace(".", ",");
    var forma = $(this).find(".forma-pagamento option:selected").text();
    var data_vencimento = $(this).find(".data-vencimento").val();
    var observacoes = $(this).find(".observacoes").val();
    $("#infoPagamento").val($("#infoPagamento").val() + "> Pagamento no valor de R$"+valor+" em "+forma+" a ser efetuado até o dia "+data_vencimento);
    if (observacoes){
      $("#infoPagamento").val($("#infoPagamento").val() + " ("+observacoes+")");
    }
    if (i < quantidade_parcelas){
      $("#infoPagamento").val($("#infoPagamento").val() + "\n\n");
    }
    i++;
  })
}

function resetarAutocompleteCliente(){
  var $ = jQuery;
  $(".resetarAutocompleteCliente").unbind("click").click(function(){
    $("#cliente").removeAttr("readonly").val("");
    $("#clienteid").val("");
    $(this).remove();
    resizeJquerySteps();
    return false;
  })
}

function resetarAutocompleteImovel(){
  var $ = jQuery;
  $(".resetarAutocompleteImovel").unbind("click").click(function(){
    $("#imovel").removeAttr("readonly").val("");
    $("#imovelid").val("");
    $(this).remove();
    resizeJquerySteps();
    return false;
  })
}

function locacaotemporada_autocomplete(){
  var url_cliente = $("#cliente").attr("data-action");
  var url_imovel = $("#imovel").attr("data-action");
  $("#cliente").autocomplete({
    source: url_cliente,
    minLength: 2,
    select: function( event, ui ) {
      $("#clienteid").val(ui.item.id);
      $("#cliente").attr("readonly", "readonly").after('<a href="#" class="resetarAutocompleteCliente btn btn-danger btn-xs">[X]</a>');
      resetarAutocompleteCliente();
      resizeJquerySteps();
    }
  });
  $("#imovel").autocomplete({
    source: url_imovel,
    minLength: 2,
    select: function( event, ui ) {
      $("#imovelid").val(ui.item.id);
      $("#imovel").attr("readonly", "readonly").after('<a href="#" class="resetarAutocompleteImovel btn btn-danger btn-xs">[X]</a>');
      resetarAutocompleteImovel();
      resizeJquerySteps();
    }
  });
}