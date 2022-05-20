import React, { useState } from 'react';

const changeSlider = (evt, checked, setIsChecked) => {
	let input = evt.target;
	
	setIsChecked(input.checked);
}

function ToggleSwitch (props) {
	const {name, checked, setChecked} = props;
	const [isChecked, setIsChecked] = useState(checked);
	return (
		<label className="switch">
			<input type="checkbox" name={name} value={isChecked} defaultChecked={isChecked} onChange={(evt) => changeSlider(evt, isChecked, setIsChecked)}/>
			<span className="slider"></span>
		</label>
	)
}

export default ToggleSwitch;