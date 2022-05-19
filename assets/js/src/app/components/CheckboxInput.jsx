import React, { useState } from 'react';

function CheckboxInput(props) {
	
	const {fieldType, fieldName, fieldLabel, fieldOptions, required} = props;


	return (
		<div className="form-check">
			<input 
				className="form-check-input"
				type="checkbox"
				name={fieldName}
				required={required}
			/>
			<label className="form-check-label">{fieldLabel}</label>
		</div>
	)
}

export default CheckboxInput;