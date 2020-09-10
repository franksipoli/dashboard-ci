$(document).ready(function(){

	/*
	Função para verificar novas mensagens e marcar na área de notificação
	*/

	function message_check(){
	    $.ajax({
	    	url : '/msg/mensagem/check'
	    	,method : 'post'
	    	,dataType : 'json'
	    	,success : function(e){
	    		
	    		var html = '';
	    		var markup = new Array();

	    		if(e.total > 0){
	    			$('.total-msg').html(e.total).show();
	    		}else{
	    			$('.total-msg').hide();
	    		}

	    		$.each(e.data, function(i, val) {
	    			var subject = val.subject;
	    			subject = (subject.length > 20) 
	    				? '<span title="'+subject+'">'+subject.substr(0,20)+'...</span>' 
	    				: subject;
					
					html = '<a href="/msg/mensagem/visualizar/'+val.msg_id+'" class="list-group-item">';
					html += '<div class="media-box">';
					html += '<div class="pull-left">';
					html += '<em class="fa fa-envelope fa-2x"></em></div>';
					html += '<div class="media-box-body clearfix">'
					html += '<p class="m0">'+subject+'</p>';
					html += '<p class="m0 text-muted"><small>'+val.sender_name+'</small></p>';
					html += '</div></div></a>';
					markup.push(html);
				});
				$('.msg-list .content').html( markup.join('') );

				if(e.	rest > 0){
					$('.msg-list .link small').html('+ '+e.rest+' mensagens não lidas');
				}else{
					$('.msg-list .link small').html('Ver mensagens');
				}
	    	}
	    })
	}
	message_check();
	setInterval( message_check , 30000);

})