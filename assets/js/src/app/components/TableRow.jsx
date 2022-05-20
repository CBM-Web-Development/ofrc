import React, { useState } from 'react';
import TableColumn from './TableColumn.jsx';

function TableRow( props ) {
	const{ rowData, rowColumns, rowKey, removeRow } = props;
		
	return (
		<tr key={rowKey}>
			{rowColumns.map((column, key) => (
				<TableColumn 
					key={key}
					type={column.type}
					name={column.name}
					data={rowData[key]}
					options={column.options}
					columnKey={key}
				/>
			))}
			<td key={"removeRowColumn"} align="center">
				<button onClick={removeRow} className="btn"><i className="fa-solid fa-circle-minus"></i></button>
			</td>
		</tr>
	)
}

export default TableRow;