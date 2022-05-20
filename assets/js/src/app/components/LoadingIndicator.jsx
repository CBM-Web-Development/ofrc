import React, { useState } from 'react';

function LoadingIndicator( props ){
	return (
		<div className="loading-indicator-section">
			<i className="fa-solid fa-spinner fa-3x fa-spin-pulse"></i>
		</div>
	)
}

export default LoadingIndicator;