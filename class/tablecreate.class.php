<?php
class tablecreate {
	static function htmltable_assarrey($array) {
		$html = '';
		$html .= '<table>';
		$html .= '<tr>';
		$title = get_object_vars($array[0]);
		foreach ($title as $key=>$value) {	
				$html .= "<td>$key</td>";
			}
		$html .= '</tr>';

		foreach ($array as $raw) {
			$html .= '<tr>';
			$rawarrey = get_object_vars($raw);
			foreach ($rawarrey as $column) {	
				$html .= "<td>$column</td>";
			}
			$html .= '</tr>';
		}		
		$html .= '</table>'; 

		return $html;
	}
}
?>