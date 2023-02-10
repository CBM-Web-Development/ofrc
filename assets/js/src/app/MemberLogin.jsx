import React, { useState } from 'react';
import * as ReactDOM from 'react-dom';
import * as ReactDOMClient from 'react-dom/client';
import $ from 'jquery';
import Form from './components/Form.jsx';
import apiFetch from '@wordpress/api-fetch';
import LoadingIndicator from './components/LoadingIndicator.jsx';


const container = document.getElementById("member-login");

if ( container !== undefined && container !== null){
	const root = ReactDOMClient.createRoot(container);
	root.render(<App />)
}

const showError = (message) => {
		
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
		setIsLoading(false);
		if(response.success === true){
			showSignInForm(evt);
		}else{
			showError(response.data.reason);
			console.log('fail');
		}
	});
}


const forgotPasswordReset = (evt, setIsLoading) => {
	evt.preventDefault();
	
	setIsLoading(true);
	
	var form = evt.target;
	
	
	var data = $(form).serialize();
	
	$.post(localize.rest_password_reset_request, data)
	.fail(function(error){
		console.log(error);
	})
	.done(function(response){
		setIsLoading(false);
		showPasswordResetForm(evt);
	});
	
	
}


const handleLoginError = (errors) => {

	errors.forEach(function(error){

		if(error.code.toLowerCase().indexOf('password') > -1){
			$('input[name=password]').addClass('is-invalid');
			$('input[name=password]').after('<div class="invalid-feedback">' + error.message + '</div>');
		}
		
		if(error.code.toLowerCase().indexOf('email') > -1){
			
			$('input[name=username]').addClass('is-invalid');
			$('input[name=username]').after('<div class="invalid-feedback">' + error.message + '</div>');
		}
	});
}

const resetPassword = (evt, setIsLoading) => {
	evt.preventDefault();
	
	var form = evt.target;
	
	var data = $(form).serialize();
	
	$.post(localize.rest_reset_password, data)
	.fail(function(error){
		console.log(error);
	})
	.done(function(response){
		setIsLoading(false);
		if(response.success === true){
			showSignInForm(evt);
		}
	})
}

const memberSignIn = (evt, setIsLoading) => {
	evt.preventDefault();
	
	setIsLoading(true);
	
	var form = evt.target;
	
	var data = $(form).serialize();
	
	$.post(localize.rest_member_login, data, function(){})
	.fail(function(error){
		console.log(error);
	})
	.done(function(response){
		setIsLoading(false);
		console.log(response);
		if(response.success === false){
			if(response.data !== undefined){
				handleLoginError(response.data);
			}else{
				handleLoginError([
					{code: 'password', message: 'Password is empty'},
					{code: 'email', message: 'Username is empty'}
				]);
			}	
		}else{
			window.location.reload();
		}
		
	});
	
}

const showForgotPasswordForm = (evt) => {
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

const showPasswordResetForm = (evt) => {
	evt.preventDefault();
	$('.member-forgot-login-form').fadeToggle();
	$('.member-reset-password-form').fadeToggle();
}


function App(){
	
	const[isLoading, setIsLoading] = useState(false);
	const[isNewUserForm, setIsNewUserForm] = useState(false);
	const[isForgotLoginForm, setIsForgotLoginForm] = useState(false);
	const[isLoginForm, setIsLoginForm] = useState(true);
	const signInFields = [
		{name: 'username', label: 'Username', type: 'email'},
		{name: 'password', label: 'Password', type: 'password'},
		{name: 'remember', label: 'Remember Me', type: 'checkbox'}
	];
	
	const forgotPasswordFields = [
		{name: 'username', label: 'Username/email', type: 'text'}
	]
	
	const signUpFields = [
		{name: 'membership_id', label: 'Membership ID', type: 'text', required: true}, 
		{name: 'email', label: 'Email', type: 'email', required: true},
		{name: 'password', label: 'Password', type: 'password', required: true},
		{name: 'first_name', label: 'First Name', type: 'text'},
		{name: 'last_name', label: 'Last Name', type: 'text'},
	];
	
	const resetPasswordFields = [
		{name: 'reset_key', label: 'Reset Key', type: 'text', required: true},
		{name: 'login', label: 'Email', type: 'email', required: true},
		{name: 'password', label: 'New Password', type: 'password', required: true},
		
	]
		
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
				formName={"Request Password Reset"}
				formName={"member-forgot-login-form"}
				formClassName={"form member-forgot-login-form"}
				onSubmit={forgotPasswordReset}
				formFields={forgotPasswordFields}
				submitButtonText={"Reset Password"} 
				showForgotPasswordForm={showForgotPasswordForm}
				showSignInForm={showSignInForm}
				setIsLoading={setIsLoading}
			/>
			
			<Form 
				formTitle={"Reset Password"}
				formName={"member-reset-password-form"}
				formClassName={"form member-reset-password-form"}
				onSubmit={resetPassword}
				formFields={resetPasswordFields}
				submitButtonText={"Reset Password"}
				showSignInForm={showSignInForm}
				setIsLoading={setIsLoading} />
		</div>
		
	)
	
}