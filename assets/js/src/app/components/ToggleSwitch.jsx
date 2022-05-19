import React, { useState } from 'react';

function ToggleSwitch (props) {
	const {name, checked} = props;
	return (
		<label className="switch">
			<input type="checkbox" name={name} defaultChecked={checked} />
			<span className="slider"></span>
		</label>
	)
}

export default ToggleSwitch;