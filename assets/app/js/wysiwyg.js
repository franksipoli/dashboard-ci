jQuery(document).ready(function(){
	var $ = jQuery;
	$(".wysiwyg").each(function(){
		$(this).closest("form").submit(function(){
			$(this).find("#recebe-wysiwyg").val($(this).find(".wysiwyg").html());
		});
	})
	$('.wysiwyg').wysiwyg();
})