jQuery(document).ready(function($) {
	// Stuff to do as soon as the DOM is ready;
	$('.showBlock').on('click', function(e){
		e.preventDefault();
		$(this).parent().parent().next().toggle('slow');
		$(this).text(($(this).text() == 'Show')?'Hide':'Show');
	});

	$('.sendServices').on('click', function(e){
		e.preventDefault();
		var buttonRef = $(this);
		var i = buttonRef.attr('data-i');
		var response = $('.showResponse-'+i);
		var form = $('.servicesForm-'+i);
		var formData = form.serialize();
		$.ajax({
			url : 'client.php',
			type : 'POST',
			data : formData,
			dataType : 'html',
			beforeSend : function(){
				buttonRef.attr('disabled',true).attr('default-text',buttonRef.text()).text(buttonRef.attr('data-loading-text'));
				response.html(' ');
			},
			success : function(data){
				console.log(data);
				response.html(data);
			},
			error : function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
				//response.val(data)	
			},
			complete : function(){
				buttonRef.attr('disabled',false).text(buttonRef.attr('default-text'));
			}
		})
	});	
});