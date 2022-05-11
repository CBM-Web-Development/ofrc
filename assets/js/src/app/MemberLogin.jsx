import React, { useState } from 'react';
import * as ReactDOM from 'react-dom';
import * as ReactDOMClient from 'react-dom/client';
import $ from 'jquery';
import Form from './components/Form.jsx';
import apiFetch from '@wordpress/api-fetch';
import LoadingIndicator from './components/LoadingIndicator.jsx';


const container = document.getElementById("member-login");

if ( container !== undefined ){
	const root = ReactDOMClient.createRoot(container);
	root.render(<App />)
}

const showError = (message) => {
	
	console.log(message)
	
	if(message.toLowerCase().indexOf('username') > -1 ){
		$('input[name=email]').addClass('is-invalid');
		$('input[name=email]').after('<div class="invalid-feedback">' + message + '</div>');
	}
	
	if(message.toLowerCase().indexOf('password') > -1 ) {
		
		$('input[name=password]').addClass('is-invalid');
		$('input[name=password]').after('<div class="invalid-feedback">' + message + '</div>');
		
	}
	
	if(message.toLowerCase().indexOf('member') > -1 ){
		
		$('input[name=membership_id]').addClass('is-invalid');
		$('input[name=membership_id]').after('<div class="invalid-feedback">' + message + '</div>');
		
	}
}

const showSignInForm = (evt) => {
	evt.preventDefault();

	let form = $(evt.target).closest('form');

	$(form).fadeOut();
	$('.member-sign-in-form').fadeIn();
	
}

const isPasswordValid = (password) => {
	if(password.length < 8){
		console.log('length');
		return false;
	}
	
	if(!password.match(/[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/)){
		console.log('characters');
		return false;
	}
	
	if(!password.match(/\d/)){
		console.log('digits');
		return false;
	}
	
	if(!password.match(/[A-Za-z]/)){
		console.log('letters');
		return false;
	}
	
	return true
	
}

const memberSignUp = (evt, setIsLoading) => {
	evt.preventDefault();
	setIsLoading(true);
	let form = evt.target;
	
    let password = $(form).find('input[name=password]').val();
	
	if(!isPasswordValid(password)){
		setIsLoading(false);
		showError('Password is invalid. Your password must be a minimum of 8 characters and container at least one letter and one symbol.');
		return false;
	}
	
	var data = $(form).serialize();
	
	
	$.post(localize.rest_member_signup, data, function(){})
	.fail(function(error){
		console.log(error);
	})
	.done(function(response){
		console.log(response);
		setIsLoading(false);
		if(response.success === true){
			showSignInForm(evt);
		}else{
			showError(response.data.reason);
			console.log('fail');
		}
	});
}


const forgotPasswordReset = (evt) => {
	evt.preventDefault();
}

const memberSignIn = (evt) => {
	evt.preventDefault();
	
	
}

const showForgotPasswordForm = (evt) => {
	console.log(evt);
	evt.preventDefault();
	
	$('.member-sign-in-form').fadeToggle();
	var form = evt.target;
	
	$(form).fadeOut();
	$('.member-forgot-login-form').fadeIn();
}

const showSignUpForm = (evt) => {
	evt.preventDefault();
	
	$('.member-sign-in-form').fadeToggle();
	$('.member-sign-up-form').fadeToggle();
}

function App(){
	
	const[isLoading, setIsLoading] = useState(false);
	const[isNewUserForm, setIsNewUserForm] = useState(false);
	const[isForgotLoginForm, setIsForgotLoginForm] = useState(false);
	const[isLoginForm, setIsLoginForm] = useState(true);
	const signInFields = [
		{name: 'username', label: 'Username', type: 'text'},
		{name: 'password', label: 'Password', type: 'password'}
	];
	
	const forgotPasswordFields = [
		{name: 'username', label: 'Username/email', type: 'text'}
	]
	
	const signUpFields = [
		{name: 'email', label: 'Email', type: 'email', required: true},
		{name: 'password', label: 'Password', type: 'password', required: true},
		{name: 'membership_id', label: 'Membership ID', type: 'text', required: true}, 
		{name: 'first_name', label: 'First Name', type: 'text'},
		{name: 'last_name', label: 'Last Name', type: 'text'},
	]
	
	console.log(signUpFields);
	
	return (
		<div>
			{isLoading && 
				<LoadingIndicator />
			}
			<Form 
				formTitle={"Log In"}
				formName={"member-sign-in-form"}
				formClassName={"form member-sign-in-form"}
				onSubmit={memberSignIn}
				formFields={signInFields}
				submitButtonText={"Sign In"} 
				showSignUpForm={showSignUpForm}
				showForgotPasswordForm={showForgotPasswordForm}
				setIsLoading={setIsLoading}
			/>
			
			
			<Form 
				formTitle={"Sign Up"}
				formName={"member-sign-up-form"}
				formClassName={"form member-sign-up-form"}
				onSubmit={memberSignUp}
				formFields={signUpFields}
				submitButtonText={"Sign Up"} 
				showSignInForm={showSignInForm}
				setIsLoading={setIsLoading}
			/>
			
			
			<Form 
				formName={"member-forgot-login-form"}
				formClassName={"form member-forgot-login-form"}
				onSubmit={forgotPasswordReset}
				formFields={forgotPasswordFields}
				submitButtonText={"Reset Password"} 
				showForgotPasswordForm={showForgotPasswordForm}
				showSignInForm={showSignInForm}
				setIsLoading={setIsLoading}
			/>
		</div>
		
	)
	
}