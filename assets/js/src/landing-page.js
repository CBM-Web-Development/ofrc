import $ from 'jquery';

$(document).ready(function(){

	if($('.landing-page').length > 0){
		var position = $(document).scrollTop();
		var isNavbarVisible = false;
		var heroHeight = $('.landing-hero').height();
		
		console.log(heroHeight);

		if(position > heroHeight && isNavbarVisible === false){
			setNavbarVisible(true);
		}
		$(window).scroll(function(){
			
			position = $(document).scrollTop();
			
			if(position > heroHeight && isNavbarVisible === false){
				setNavbarVisible(true);
				isNavbarVisible = true;
			}else if (position < heroHeight && isNavbarVisible === true){
				setNavbarVisible(false);
				isNavbarVisible = false;
			}
			
		});
	}
});

function setNavbarVisible(setVisible){
	console.log('change-visibility');
	if(setVisible === true){
		$('.primary-navbar').fadeIn();
	}else{
		$('.primary-navbar').fadeOut();
	}
}