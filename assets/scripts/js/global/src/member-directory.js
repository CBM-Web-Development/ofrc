var $ = require('jquery');
var List = require('list.js');
var bootstrap = require('bootstrap');

$(document).ready(function(){
	
	$('.signoutButton').on('click', function(e){
		e.preventDefault();
		
		showLoading();
		
		$.post(localize.ajax_url,{action:'signout'}, function(success){})
		.fail(function(error){
			console.log(error);
		})
		.done(function(response){
			
			hideLoading();
			location.reload();
		});
	});
		
	$('.member-login--form').on('submit', signUserIn);
	
	if($('.member-profile-archives-page')[0]){
		get_member_directory();
	}
	
	// Display the profile picture sample
	$('.profile-picture-input').on('change', function(evt){
		
		var file = evt.target.files;
		
		if(file){
			var img;
			if($('.profile-picture-form-display--img').length > 0){
				console.log('exists');
				img = $('.profile-picture-form-display--img');
				$('.profile-picture-form-display--img').attr('src', URL.createObjectURL(file[0]));
			}else{
				img = document.createElement('img');
				img.className = "profile-picture-form-display--img";
				$('.profile-picture-form-display').html(img);
				
				img.src = URL.createObjectURL(file[0]);
			}
				
			upload_member_profile_image(file[0]);
		}
	});
});

function showLoading(){
	console.log('loading');
	$('.member-profile-container').children().attr('disabled', true);
	$('.member-profile-container').children().css({
		opacity: 0.3
	});
	$('.loading-indicator').show();
	
}

function hideLoading(){
	console.log('done loading');
	$('.member-profile-container').children().attr('disabled', false);
	$('.member-profile-container').children().css({
		opacity: 1.0
	});
	$('.loading-indicator').hide();
}

function signUserIn(){
	
	showLoading();
	
	var data = $('.member-login--form').serialize();
	
	data += '&action=member_login';
	
	$.post(localize.ajax_url, data, function(success){}, 'json')
	.fail(function(error){
		console.log("Error: " + error);
	})
	.done(function(response){
		if(response.data.success === false){
			if(response.data.error === 'password'){
				$('input[name=user_password]').addClass('is-invalid');
			}else{
				$('input[name=user_login]').addClass('is-invalid');
			}
		}else{
			location.reload();
		}
		
		hideLoading();
		
	});
	return false;
}


function upload_member_profile_image(file){
	showLoading();
	
	var form_data = new FormData();
		
	form_data.append('profile_image', file);
	form_data.append('user_id', localize.current_user_id);
	$.ajax({
		url: localize.rest_member_upload_profile_image, 
		type: 'POST', 
		data: form_data, 
		cache: false,
		processData: false, 
		contentType: false, 
		success: function(success){},
		error: function(error){
			console.log('error');
			console.log(error);
		}, 
	}).done(function(response){
		hideLoading();
		showToastMessage('success', 'Image Saved', 'Your profile image has been saved');
	});
	
	
	
}

window.update_member_profile = function(){
	showLoading();
	var form_data = $('.member-profile').serialize();
	form_data += "&current_user=" + localize.current_user_id;
	
	console.log(form_data);
	$.post(localize.rest_member_save_profile, form_data, function(response){
		console.log(response);
	}).fail(function(error){
		console.log(error);
	}).done(function(response){
		hideLoading();
		if(response.success === true){
			showToastMessage('success', 'Profile Updated', 'Your profile has been updated successfully.');
		}else{
			showToastMessage('fail', 'Failed to Save', 'Your profile failed to save. Please try again.');
		}
	});
		
	return false;
}

function showToastMessage(type, title, message){
	var toastDiv = $('.toast');
	$('.toast-header--text').text(title);
	$('.toast-body').html(message);
	
	var toast = new bootstrap.Toast(toastDiv);
	toast.show();
}

function get_member_directory(){
	$.post(localize.rest_member_directory,{},function(success){})
	.fail(function(error){
		console.log(error);
	}).done(function(response){
		build_directory_html(response);
	});
}

function build_directory_html(members){

	var options = {
		page: 10, 
		pagination: {
			item: '<li class="page-item"><a class="page page-link" href="#"></a></li>'
		},
		valueNames: [
			'name',
			'biography',
			{attr: 'src', name: 'profile_picture'},
			{attr: 'href', name: 'phone_number_link'},
			{attr: 'href', name: 'email_link'},
			'phone_number', 
			'email',
			'phone_number_display',
		],
		item: '<li class="member-profile--item"><img class="profile_picture" alt="" src=""><div class="directory-body"><h3 class="name"></h3><a class="phone_number_link"><span class="phone_number_display"></span></a><a class="email_link" href=""><span class="email"></span></a><p class="biography"></p></div></li>'
	};
		
	var directoryList = new List('member-profile-list', options, members);
	$('.fa-spinner').hide();
}