import React, { useEffect } from 'react';
import Input from './Input.jsx';
import ImageInput from './ImageInput.jsx';
import SelectInput from './SelectInput.jsx';
import ToggleSwitch from './ToggleSwitch.jsx';

function TableColumn ( props ) {
	
	const { columnKey, type, name, options, data } = props;
		
	return (
		<td key={columnKey} align="center">
			
			{ type === 'image' &&
				<ImageInput 
					src={data.value} 
					attachmentId={data.attachment_id}
				/>
			}
			
			{ type === 'text' && 
				<Input 
					type={type}
					name={name}
					required={true}
					value={data.value !== undefined ? data.value : ''} />
			}
			
			{ (type === 'email' || type === 'datetime-local' || type === "tel" || type === 'date') && 
				<Input 
					type={type}
					name={name}
					required={false}
					value={data.value !== undefined ? data.value : ''} />
			}
			{ type === 'select' && 
				<SelectInput 
					options={options}
					value={data.value}
					name={name} />
			}
			
			{ type === 'switch' && 
				<ToggleSwitch
					checked={data.value !== undefined ? data.value : false}
					name={name}
					/>
			}
			
		</td>
	)
}

export default TableColumn;