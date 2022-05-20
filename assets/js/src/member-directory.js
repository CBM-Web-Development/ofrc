var $ = require('jquery');
var List = require('list.js');
var bootstrap = require('bootstrap');
import apiFetch from '@wordpress/api-fetch';

$(document).ready(function(){
	
	$('.profile-picture-mask').on('click', function (e){
		$('.profile-picture-input').trigger('click');
	});
	
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
	
	
	var member_group_table = $('.member-group-table');
	var member_group_table_rows = $(member_group_table).find('tbody tr');
		
	var member_groups = [];
	
	const formData = new FormData();	
	
	member_group_table_rows.each(function(r, v){
		
		let inputs = $(v).find(':input');
				
		inputs.each(function(c, v){
			
			let type = $(v).attr('type');
			let name = $(v).attr('name');
			var value = $(v).val();
			
			if(type === 'file'){			
				let removed = $(v).data('removed');
				let file = $(v).prop('files')[0];
				let aid = $(v).data('aid');
				
				if(file !== undefined && file !== ''){
					formData.append('member_groups_' + name + '_' + r, file);
				}else if(removed === true){
					formData.append('member_groups_' + name + '_' + r, '');
					formData.append('member_groups_remove_profile_picture_' + r, removed);
					
				}else if(aid !== undefined){
					formData.append('member_groups_profile_picture_aid' + r, aid);
				}
			}else if(name !== undefined && type !== 'file'){	
				formData.append('member_groups_' + name + '_' + r, value);	
			}
		});
		
	});	
	
	formData.append("current_user_id", localize.current_user_id);
	formData.append("membership_id", localize.current_member_group_id);
	
	
	$.ajax({
		url: localize.rest_member_save_profile, 
		type: 'POST', 
		data: formData, 
		cache: false,
		processData: false, 
		contentType: false, 
		success: function(success){},
		error: function(error){
			console.log('error');
			console.log(error);
			hideLoading();
		}, 
	}).done(function(response){
		hideLoading();
		console.log(response);
		showToastMessage('success', 'Profile Saved', 'Your changes have been saved');
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
		page: 25, 
		pagination: {
			item: '<li class="page-item"><a class="page page-link" href="#"></a></li>'
		},
		valueNames: [
			'name',
			{attr: 'src', name: 'profile_picture'},
			{attr: 'href', name:'permalink'}
		],
		item: '<li class="member-profile--item"><img class="profile_picture" alt="" src=""><div class="directory-body"><h3 class="name"></h3><a class="permalink btn btn-outline-secondary member-profile--item-link">View Profile</a></div></li>'
	};
		
	var directoryList = new List('member-profile-list', options, members);
	$('.fa-spinner').hide();
}