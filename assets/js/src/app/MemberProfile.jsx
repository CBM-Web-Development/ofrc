import React, { useState, useEffect } from 'react';
import * as ReactDOM from 'react-dom';
import * as ReactDOMClient from 'react-dom/client';
import apiFetch from '@wordpress/api-fetch';

let container = document.getElementById('member-profile-section');


if(container !== undefined && container !== null){
	const root = ReactDOMClient.createRoot(container);
	root.render(<App />);
}

const saveProfileChanges = (e) => {
	e.preventDefault();

	let form = e.target;

	const data = {
		'first_name'	: 	form.firstName.value,
		'last_name'		: 	form.lastName.value,
		'birthday'		: 	form.birthday.value,
		'homePhone'		: 	form.homePhone.value,
		'cellPhone'		: 	form.cellPhone.value,
		'workPhone'		: 	form.workPhone.value,
	}
	
	
	apiFetch( {
		headers: {
			'X-WP-Nonce' : localize.rest_nonce,
		},
		credentials: 'include',
		path: localize.rest_member_save_profile, 
		data: data, 
		method: 'POST'
	})
	.then((response) => {
		console.log(response);
	})
	.catch((error) => {
		console.log(error);
	});
	
}

const getMember = (setMember) => {
	let data = {
		user_id: localize.current_user_id, 
	}
		
	apiFetch( {
		path: localize.rest_get_member,
		data: data, 
		method: 'POST', 
	} )
	.then( (response) => {
		console.log(response);
		setMember(response);
	})
	.catch((error) => {
		console.log(error);
	});
}

const formatPhoneNumber = (e, setFormattedPhoneNumber) => {
	const input = e.target.value;
	
	const phoneNumber = input.replace(/[^\d]/g, '');
	
	const phoneNumberLength = phoneNumber.length;
	
	const formattedPhoneNumber = '';
	
	if(phoneNumberLength < 4) {
		return phoneNumber;
	}
	
	if(phoneNumberLength < 7) {
		return `(${phoneNumber.slice(0, 3)}) ${phoneNumber.slice(3)}`;
	}
	
	return`(${phoneNumber.slice(0, 3)}) ${phoneNumber.slice(3, 6)}-${phoneNumber.slice(6, 10)}`;
	
}



function App() {
	
	const [member, setMember] = useState([]);
	const [formattedPhoneNumber, setFormattedPhoneNumber] = useState();
	const [formattedWorkPhoneNumber, setFormattedWorkPhoneNumber] = useState();
	const [formattedCellPhoneNumber, setFormattedCellPhoneNumber] = useState();
	
	const columns = [
		{type: 'image', name: 'profile_picture'},
		{type: 'text', name: 'first_name'},
		{type: 'text', name: 'last_name'},
		{type: 'email', name: 'email_address'},
		{type: 'tel', name: 'phone_number'},
		{type: 'date', name: 'birthday'},
		{type: 'switch', name: 'show_in_directory', value: ''},
	]
	
	useEffect(() => {
		getMember(setMember);
	}, [])
	
	return (
		<form className="membershipInformationForm" onSubmit={saveProfileChanges}>
			<div className="nonce">
				{localize.rest_nonce}
			</div>
			<div className="membershipInformation">
				<div className="d-flex flex-column align-items-center mb-3">
					<label><strong>Profile Picture</strong></label>
					<img src={member.profile_picture} className="profile-picture"/>
				</div>
				<div className="form-floating mb-3">
		  			<input type="text" className="form-control" id="floatingInput" placeholder="Membership ID" defaultValue={member.membership_id} disabled/>
		  			<label htmlFor="floatingInput">Membership ID</label>
				</div>
				<div className="form-floating mb-3">
				  	<input type="text" className="form-control" id="floatingInput" placeholder="Member User ID" defaultValue={member.user_id} disabled/>
				  	<label htmlFor="floatingInput">User ID</label>
				</div>
				<div className="form-floating mb-3">
		  			<input type="email" className="form-control" id="floatingInput" placeholder="name@example.com" defaultValue={member.email_address} disabled/>
		  			<label htmlFor="floatingInput">Email Address/Username</label>
				</div>
				<div className="form-floating mb-3">
				  	<input type="text" className="form-control" id="floatingInput" placeholder="First Name" defaultValue={member.first_name} name="firstName"/>
				  	<label htmlFor="floatingInput">First Name</label>
				</div>
				<div className="form-floating mb-3">
				  	<input type="text" className="form-control" id="floatingInput" placeholder="Last Name" defaultValue={member.last_name} name="lastName"/>
				  	<label htmlFor="floatingInput">Last Name</label>
				</div>
				<div className="form-floating mb-3">
				  	<input type="date" className="form-control" id="floatingInput" placeholder="Birthday" defaultValue={member.birthday} name="birthday"/>
				  	<label htmlFor="floatingInput">Birthday</label>
				</div>
				<div className="form-floating mb-3">
				  	<input type="tel" className="form-control" id="floatingInput" placeholder="Home Phone" defaultValue={member.home_phone} name="homePhone" onChange={(e) => setFormattedPhoneNumber(formatPhoneNumber(e, setFormattedPhoneNumber))} value={formattedPhoneNumber}/>
				  	<label htmlFor="floatingInput">Home Phone</label>
				</div>
				<div className="form-floating mb-3">
				  	<input type="text" className="form-control" id="floatingInput" placeholder="Cell Phone" defaultValue={member.cell_phone} name="cellPhone" onChange={(e) => setFormattedCellPhoneNumber(formatPhoneNumber(e, setFormattedPhoneNumber))} value={formattedCellPhoneNumber}/>
				  	<label htmlFor="floatingInput">Cell Phone</label>
				</div>
				<div className="form-floating mb-3">
				  	<input type="text" className="form-control" id="floatingInput" placeholder="Work Phone ID" name="workPhone" defaultValue={member.work_phone} onChange={(e) => setFormattedWorkPhoneNumber(formatPhoneNumber(e, setFormattedPhoneNumber))} value={formattedWorkPhoneNumber}/>
				  	<label htmlFor="floatingInput">Work Phone</label>
				</div>
			</div>
			<div className="row ms-5 mb-5">
				<button className="btn btn-outline-primary" type="submit">Save Changes</button>
			</div>
		</form>
	)
}