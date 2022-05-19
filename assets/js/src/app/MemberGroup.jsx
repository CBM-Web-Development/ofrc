import React, { useState, useEffect } from 'react';
import * as ReactDOM from 'react-dom';
import * as ReactDOMClient from 'react-dom/client';
import TableRow from './components/TableRow.jsx';
import apiFetch from '@wordpress/api-fetch';

let container = document.getElementById('member-group-section');


if(container !== undefined && container !== null){
	const root = ReactDOMClient.createRoot(container);
	root.render(<App />);
}


const removeRow = (evt) => {
	let row = evt.target.closest('tr');
	row.remove();
}

const getMembers = (members, setMembers) => {
	let data = {
		membership_id: localize.current_member_group_id, 
	}
	
	apiFetch( {
		path: localize.rest_get_member_group,
		data: data, 
		method: 'POST', 
	} )
	.then( (posts) => {
		console.log(posts.data);
		setMembers(posts.data);
		
	});
}

const addMemberRow = (evt, members, setMembers) => {

	setMembers(members => [...members, [
		{data_type: 'image', name: 'profile_picture', value: '', attachment_id: ''},
		{data_type: 'text', name: 'first_name', value: ''},
		{data_type: 'text', name: 'last_name', value: ''},
		{data_type: 'select', name: 'relationship', value: ''},
		{data_type: 'switch', name: 'show_in_directory', value: ''},
	]]);
	
}


function App() {
	
	const [members, setMembers] = useState([]);
	const columns = [
		{type: 'image', name: 'profile_picture'},
		{type: 'text', name: 'first_name'},
		{type: 'text', name: 'last_name'},
		{type: 'select', name: 'relationship', options: [{value: 'spouse', label: 'Spouse'}, {value: 'partner', label: 'Partner'}, {value: 'child', label: 'Child'}, {value: 'grandparent', label: 'Grandparent'}, {value: 'babysitter', label: 'Babysitter'}]},
		{type: 'switch', name: 'show_in_directory'},
	]
	
	useEffect(() => {
		getMembers(members, setMembers);
	}, [])
	
	return (
		<table className="member-group-table" width="100%">
			<thead>
				<tr>
					<th className="text-center">Profile Picture</th>
					<th className="text-center">First Name</th>
					<th className="text-center">Last Name</th>
					<th className="text-center">Relationship</th>
					<th className="text-center">Show in Directory</th>	
					<th></th>		
				</tr>
			</thead>
			<tbody>
				{members.map((member, key) => (
					<TableRow 
						key={key}
						rowData={member} 
						rowColumns={columns}
						rowKey={key}
						removeRow={removeRow}
					/>
				))}
			</tbody>
			<tfoot>
				<tr>
					<td colSpan={5} align={"center"}>
						<button type="button" className="btn" onClick={(evt) => addMemberRow(evt, members, setMembers)}><i className="fa-solid fa-circle-plus"></i></button>
					</td>
				</tr>
			</tfoot>
		</table>
	)
}