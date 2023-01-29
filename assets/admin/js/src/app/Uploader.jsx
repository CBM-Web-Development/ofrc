import React, {useState, useEffect} from 'react';
import * as ReactDOM from 'react-dom';
import * as ReactDOMClient from 'react-dom/client';
import $ from 'jquery';
import apiFetch from '@wordpress/api-fetch';
import { FormFileUpload, Button, Spinner } from '@wordpress/components';
import Papa from "papaparse"; 

const container = document.getElementById('memberships-uploader');

if(container !== undefined && container !== null){
	const root = ReactDOMClient.createRoot(container);
	root.render(<App />);
}

const handleFileUpload = (event, setMemberships, setDisabled) => {
	console.log(event);
	let file = event.target.files[0];
	Papa.parse(file, {
		header:true, 
		skipEmptyLines: true, 
		complete:function(results) {
			console.log(results.data);
			setDisabled('');
			setMemberships(results.data);
		}
	});
}

const uploadMemberships = (memberships, success, setIsUploading) => {
	setIsUploading(true);
	let data = {
		memberships: memberships
	}
	
	apiFetch( {
		path: localize.upload_memberships,
		data: data, 
		method: 'POST'
	} )
	.then((response) => {
		console.log(response);
		setIsUploading(false);
	})
	.catch((error) => {
		console.log(error);
	})
	
	
}

function App(){
	
	const [memberships, setMemberships] = useState([]);
	const [disabled, setDisabled] = useState(true);
	const [success, setSuccess] = useState(false);
	const [isUploading, setIsUploading] = useState(false);
	return (
		<form>
			<input 
				type="file"
				name="file"
				accept=".csv"
				onChange={(event) => handleFileUpload(event, setMemberships, setDisabled)}
			/>
			
				<button 
					type="button" 
					onClick={(evt) => uploadMemberships(memberships, setSuccess, setIsUploading)} 
					disabled={disabled} >
					Upload
				</button>
				
				{isUploading && 
					<Spinner />
				}
				
				{success && 
					<p>{memberships.size()} were successfully uploaded</p>
				}
			
		</form>
		
	)
}
