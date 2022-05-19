import React, { useState } from 'react';

function SelectInput (props){
	const {name, options, required, value} = props;
	
	console.log(value);
	
	return (
		<select className='form-select' defaultValue={value} required={required} name={name}>
			<option value="" disabled>Select One</option>
			{options.map((option) => (
				<option value={option.value} key={option.value}>{option.label}</option>
			))}
		</select>
	)
}

export default SelectInput;