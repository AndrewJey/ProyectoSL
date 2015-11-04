$(document).ready(function(){
	$('.active_search').each(function(){
	    $('.search_songs').toggle( "slow" );
	})

	$('.search_toggle').click(function () {
    	$('.search_songs').toggle( "slow" );
	});

	$('.delete-song').click(function () {
    	var id = $(this).attr('data-id');
    	var name = $(this).attr('data-name');

    	$('#name-delete').append(name+ "?");
    	$('#modal').attr('action', '/songs/'+id);
	});

	$('.delete-artist').click(function () {
    	var id = $(this).attr('data-id');
    	var name = $(this).attr('data-name');

    	$('#name-delete').append(name+ "?");
    	$('#modal').attr('action', '/singers/'+id);
	});		
});