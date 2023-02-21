var $ = require('jquery');

$(document).ready(function(){

	if($('.archives-page')[0]){

		get_archive_posts();	
	}
});


window.get_archive_posts = function(page_number = null){
	
	var page = page_number == null ? $('.cards-section').data('page') : page_number;
	var archive = $('.cards-section').data('archive');

	var data = {
		"page" : page, 
		"category" : archive,
	};
	
	$.post(localize.rest_archives, data, function(success){})
	.fail(function(error){
		console.log(error);
	}).done(function(results){
		set_page_contents(results, page);
	});
	
}

function set_page_contents(posts, page){

	var cards_section = $('.cards-section');
	
	var card = "";
	
	var num_pages = posts.num_pages;
		
	if(posts.posts){
		$(posts.posts).each(function(index, value){
			
			card += '<div class="col d-flex align-items-stretch">';
			
			card += '<div class="card w-100 text-center mb-3">';
			
			if(value.thumbnail !== false){
				card += '<img src="';
				card += value.thumbnail;
				card += '" class="card-img-top" alt="';
				card += value.title;
				card += '">';
			}
			
			card += '<div class="card-body">';
				
			card += '<h5 class="card-title">';
			
			card += value.title; 
			
			card += '</h5>';				  
			
			card += '<p class="card-text"><small class="text-muted">';
			
			card += value.post_date; 
			
			card += '</small></p>';

			card += '<p class="card-text">';
			
			card += value.excerpt;
			
			card += '</p>';
			
			card += '</div>';
			
			card += '<div class="card-footer">';												  
			card += '<a class="btn btn-outline-dark" href="';
			
			card += value.permalink; 
			
			card += '">Read More</a>';
			
			card += '</div>';
			
			card += '</div>';
			
			card += '</div>';	
		});
	}
	
	$('.cards-section').html(card);
	
	if(num_pages > 1){
		
		var pagination = 1;
		var p = '';
		while(pagination <= num_pages){
			
			var page_item_class = "page-item";
			
			if(pagination == page){
				page_item_class += " active";
			}
			
			p += '<li class="' + page_item_class + '"><button class="page-link" data-page="' + pagination + '" onclick="window.get_archive_posts(' + pagination + ')">';
			p += pagination;
			p += '</button></li>';
			
			
			pagination += 1;
		}
		
		$('.pagination').html(p);
		
	}
	
}