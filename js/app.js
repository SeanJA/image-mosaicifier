$().ready(function(){
	$( "form" ).on( "submit", function( event ) {
	  	event.preventDefault();
	  	$('.mosaic').html('<img src="img/loading.gif" />');
	  	$('.toggle').hide();
	  	var submitted = $( this ).serialize();
	  	$.get( "encode.php", submitted, function( data ) {
		  $(".mosaic").html('<div class="table">' + data  +  '</div><div class="image hide"><img src="'+$('#image-url').val()+'" /></div>');
		  $('.toggle').show();
		});
		
	});
	$('.toggle').on('click',function(){
		$('.table').toggleClass('hide');
		$('.image').toggleClass('hide');
	});
});