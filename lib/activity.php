<?php

/**
 * Main activity stream list page
 */
function activity_view_page () {
	
	$options = array();
	
	$page_type = preg_replace('[\W]', '', get_input('page_type', 'all'));
	$type = preg_replace('[\W]', '', get_input('type', 'all'));
	$subtype = preg_replace('[\W]', '', get_input('subtype', ''));
	if ($subtype) {
		$selector = "type=$type&subtype=$subtype";
	} else {
		$selector = "type=$type";
	}
	
	if ($type != 'all') {
		$options['type'] = $type;
		if ($subtype) {
			$options['subtype'] = $subtype;
		}
	}
	
	switch ($page_type) {
		case 'mine':
			$title = elgg_echo('river:mine');
			$page_filter = 'mine';
			$options['subject_guid'] = elgg_get_logged_in_user_guid();
			break;
		case 'friends':
			$title = elgg_echo('river:friends');
			$page_filter = 'friends';
			$options['relationship_guid'] = elgg_get_logged_in_user_guid();
			$options['relationship'] = 'friend';
			break;
		default:
			$title = elgg_echo('river:all');
			$page_filter = 'all';
			break;
	}
	
	$activity = elgg_list_river($options);
	if (!$activity) {
		$activity = elgg_echo('river:none');
	}
	
	$content = elgg_view('core/river/filter', array('selector' => $selector));
	
	$sidebar = elgg_view('core/river/sidebar');
	
	$sidebar .= elgg_view('activity/module/mentions');
	
	$params = array(
		'content' =>  $content . $activity,
		'sidebar' => $sidebar,
		'sidebar_alt' => '',
		'filter_context' => $page_filter,
		'class' => 'elgg-river-layout',
	);
	
	$body = elgg_view_layout('two_sidebar', $params);
	
	return elgg_view_page($title, $body);
}