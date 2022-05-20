import React, { useState } from 'react';

function Input ( props ) {
	const {name, value, required, type} = props;
	console.log(value);
	return (
		<input 
			type={type}
			name={name}
			defaultValue={value}
			required={required}
			className={'form-control'}
		/>
	)
}

export default Input;