function resetQuantidade(){
   var $ = jQuery;
   $(".lista-grupos .checkbox").each(function(){
      if ($(this).find("input[type=checkbox]").is(":checked")){
         $(this).find("input[type=text]").show();
      } else {
         $(this).find("input[type=text]").hide();
      }
   })
}
jQuery(document).ready(function(){
   var $ = jQuery;
   $(".lista-grupos input[type=text]").hide();
   $(".lista-grupos input[type=checkbox]").change(function(){
      resetQuantidade();
   })
   resetQuantidade();
})