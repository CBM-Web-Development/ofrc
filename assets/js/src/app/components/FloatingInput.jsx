import React, { useState } from 'react';
import $ from 'react';

function FloatingInput ( props ) {
	
	const {fieldType, fieldName, fieldLabel, fieldOptions, required} = props;
		
	return (
		<div className="form-floating mb-3">
			
			{ fieldType === 'select' && 
			
				<select name={fieldName} className="form-select" required={required}>
					{fieldOptions.map((option) => (
						<option key={option.value}>{option.label}</option>
					))}
				</select>
			
			}
			
			{(fieldType === 'password' || fieldType === 'text' || fieldType === 'email' || fieldType === 'tel') && 
				<input
					type={fieldType} 
					name={fieldName} 
					className="form-control" 
					placeholder={fieldLabel} 
					required={required}
				/>
			}
			
			<label>{fieldLabel}</label>
		</div>
	)
}

export default FloatingInput;