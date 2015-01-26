<?php

$type = get_input('type');

$form_vars = call_user_func("{$type}_prepare_form_vars");

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
}

echo elgg_view_form($form_path, array(), $form_vars);
