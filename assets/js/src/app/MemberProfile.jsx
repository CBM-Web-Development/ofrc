import React, { useState, useEffect } from 'react';
import * as ReactDOM from 'react-dom';
import * as ReactDOMClient from 'react-dom/client';
import apiFetch from '@wordpress/api-fetch';

let container = document.getElementById('member-profile-section');


if(container !== undefined && container !== null){
	const root = ReactDOMClient.createRoot(container);
	root.render(<App />);
}


const removeRow = (evt) => {
	let row = evt.target.closest('tr');
	row.remove();
}

const getMember = (setMember) => {
	let data = {
		user_id: localize.current_user_id, 
	}
	
	console.log(localize.rest_get_member);
	
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

const addMemberRow = (evt, members, setMembers) => {

	setMembers(members => [...members, [
		{data_type: 'image', name: 'profile_picture', value: '', attachment_id: ''},
		{data_type: 'text', name: 'first_name', value: ''},
		{data_type: 'text', name: 'last_name', value: ''},
		{data_type: 'text', name: 'phone_number', value: ''},
		{data_type: 'email', name: 'email_address', value: ''},
		{data_type: 'datetime-local', name: 'birthday', value: ''},
		{data_type: 'switch', name: 'show_in_directory', value: ''},
	]]);
	
}


function App() {
	
	const [member, setMember] = useState([]);
	
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
				  <input type="text" className="form-control" id="floatingInput" placeholder="Membership ID" defaultValue={member.user_id} disabled/>
				  <label htmlFor="floatingInput">User ID</label>
			</div>
			<div className="form-floating mb-3">
		  		<input type="email" className="form-control" id="floatingInput" placeholder="name@example.com" defaultValue={member.email_address} disabled/>
		  		<label htmlFor="floatingInput">Email Address/Username</label>
			</div>
			<div className="form-floating mb-3">
				  <input type="text" className="form-control" id="floatingInput" placeholder="First Name" defaultValue={member.first_name} disabled/>
				  <label htmlFor="floatingInput">First Name</label>
			</div>
			<div className="form-floating mb-3">
				  <input type="text" className="form-control" id="floatingInput" placeholder="Last Name" defaultValue={member.last_name} disabled/>
				  <label htmlFor="floatingInput">Last Name</label>
			</div>
			<div className="form-floating mb-3">
				  <input type="date" className="form-control" id="floatingInput" placeholder="Birthday" defaultValue={member.birthday} disabled/>
				  <label htmlFor="floatingInput">Birthday</label>
			</div>
			<div className="form-floating mb-3">
				  <input type="tel" className="form-control" id="floatingInput" placeholder="Home Phone" defaultValue={member.home_phone} disabled/>
				  <label htmlFor="floatingInput">Home Phone</label>
			</div>
			<div className="form-floating mb-3">
				  <input type="text" className="form-control" id="floatingInput" placeholder="Cell Phone" defaultValue={member.cell_phone} disabled/>
				  <label htmlFor="floatingInput">Cell Phone</label>
			</div>
			<div className="form-floating mb-3">
				  <input type="text" className="form-control" id="floatingInput" placeholder="Work Phone ID" defaultValue={member.work_phone} disabled/>
				  <label htmlFor="floatingInput">Work Phone</label>
			</div>
		</div>
	)
}