<?php
/**
 * Prepare and display a form for adding new blog/file/bookmark
 */

$type = get_input('type');

switch ($type) {
	case 'blog':
		$form_path = 'blog/save';
		break;
	case 'file':
		$form_path = 'file/upload';
		break;
	case 'bookmarks':
		$form_path = 'bookmarks/save';
		break;
	case 'video':
		$form_path = 'video/upload';
		break;
}

$form_vars = array();

// Load the libraries that prepare the form vars
elgg_load_library("elgg:{$type}");

$preparing_function = "{$type}_prepare_form_vars";
if (function_exists($preparing_function)) {
	$form_vars = call_user_func($preparing_function);
}

echo elgg_view_form($form_path, array(), $form_vars);
