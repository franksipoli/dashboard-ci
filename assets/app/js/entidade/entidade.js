jQuery(document).ready(function(){
	var $ = jQuery;
	$("input[name=tipo_pessoa]").change(function(){
		if ($("input[name=tipo_pessoa]:checked").val()){
			$("input[name=term]").removeAttr("readonly");
		} else {
			$("input[name=term]").attr("readonly","readonly");
		}
	})
    $("input[name=term]").autocomplete({
      source: $("input[name=term]").attr("data-action"),
      minLength: 2,
      select: function( event, ui ) {
      }
    });
})