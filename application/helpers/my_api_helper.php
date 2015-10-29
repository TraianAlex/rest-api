<?php

function remove_unknown_fields($row_data, $expected_fields){

	$new_data = [];
 	foreach ($row_data as $field_name => $field_value) {
 		if($field_name != "" && in_array($field_name, $expected_fields)){
 			$new_data[$field_name] = $field_value;
 		}
 	}
	return $new_data;
}