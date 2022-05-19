import React, { useState } from 'react';
import FloatingInput from './FloatingInput.jsx';
import CheckboxInput from './CheckboxInput.jsx';
function Form( props ) {
	const { formName, formTitle, formClassName, onSubmit, formFields, submitButtonText, showSignUpForm, showForgotPasswordForm, showSignInForm, validation, setIsLoading} = props;
		
	return (

		<form 
			name={formName}
			className={formClassName}
			onSubmit={(evt) => onSubmit( evt, setIsLoading)}
		>
		
		{formName !== 'member-sign-in-form' && 
			<button type="button" className="btn" onClick={showSignInForm}><i className="fa-solid fa-chevron-left"></i> Back</button>
		}
		
		{formTitle !== undefined  && 
		
			<h2>{formTitle}</h2>
		
		}
		
		{formFields.map((field) => (
			<span>
			{field.type === 'checkbox' && 
				<CheckboxInput
				fieldType={field.type}
				fieldName={field.name}
				fieldLabel={field.label}
				required={field.required}
				fieldOptions={field.options}
				key={field.name}
				/>
			}
			
			{field.type !== 'checkbox' && 
				<FloatingInput
					fieldType={field.type}
					fieldName={field.name}
					fieldLabel={field.label}
					required={field.required}
					fieldOptions={field.options}
					key={field.name}
				/>
			}
			
			</span>
		
		))}
		<div className="d-grid gap-1 mb-3">
			<button className='btn btn-primary' type='submit'>{submitButtonText}</button>
			
			{ formName === 'member-sign-in-form' && 
				<button className="btn btn-link" onClick={showForgotPasswordForm}>{"Reset Password"}</button> 
			}
			
			{formName === 'member-sign-in-form' && 
				<button className="btn btn-link" onClick={showSignUpForm}>{"Sign Up"}</button> 
			}
		</div>
		
		</form>
	)
}

export default Form; 