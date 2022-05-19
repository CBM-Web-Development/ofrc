import React, { useState } from 'react';
import $ from 'jquery';

const triggerFileUpload = (evt) => {

	var fileUploadDiv = $(evt.target).closest('.profile-picture-form-display');
		
	var fileUploadInput = $(fileUploadDiv).find('input[name=profile_picture]');
		
	$(fileUploadInput).trigger('click');
}

const removeImage = (evt, setRemoved) => {
	evt.preventDefault();
	let deleteButton = evt.target;
	let container = $(deleteButton).closest('.profile-picture-form-display');
	let placeholderContainer = $(container).find('.profile-picture-form-display--placeholder');
	
	$(placeholderContainer).html("<i class='fas fa-file-upload'></i>");
	$(deleteButton).hide();
	
	setRemoved(true);
	
}

const imageUpload = (evt) => {
	evt.preventDefault();
	
	var file = evt.target.files;
	var profileImageDisplay = $(evt.target).closest('.profile-picture-form-display--img');
	
	console.log(file);
	
	if(file){
		var img;
		if($(profileImageDisplay).length > 0){
			console.log('yes');
			img = $('.profile-picture-form-display--img');
			$('.profile-picture-form-display--img').attr('src', URL.createObjectURL(file[0]));
		}else{
			console.log('no');
			img = document.createElement('img');
			img.className = "profile-picture-form-display--img";
			$('.profile-picture-form-display--placeholder').html(img);
			
			img.src = URL.createObjectURL(file[0]);
			
		}
	}
	
	return false;
}

function ImageInput( props ) {
	
	const{src, attachmentId} = props;
	console.log(src);
	const [removed, setRemoved] = useState(false);
		
	return (
		<div className="table-image-input profile-picture-section d-flex justify-content-center flex-column align-items-center">
			<div className="profile-picture-form-display d-flex align-items-center justify-content-center">
				<div className="profile-picture-form-display--placeholder">
					{(src === '' || src === undefined || src === null) && 
						<i className='fas fa-file-upload'></i>
					}

					
					{(src !== '' && src !== undefined && src !== null) && 
						<img className='profile-picture-form-display--img' src={src} alt="Profile Picture"/>
					}
				</div>
				

				
				<div className="profile-picture-mask" onClick={triggerFileUpload}>
					<p>Click to upload</p>
				</div>
													
				{ (src !== '' && src !== undefined && src !== null) && 
				
					<button type="button" className="remove-image-button" onClick={(evt) => removeImage(evt, setRemoved)}><i className="fa-solid fa-xmark"></i></button>
				
				}
				
			<input 
				type="file" 
				accept="image/*" 
				name="profile_picture" 
				className="form-control profile-picture-input" 
				data-removed={removed}
				data-aid={attachmentId} 
				onChange={imageUpload}/>
			</div>
		</div>
	)
}

export default ImageInput;