<?php
/**
 * Displays tabs for accessing content creation forms
 */

$plugins = array(
	'blog' => array(
		'icon' => 'speech-bubble',
	),
	'bookmarks' => array(
		'icon' => 'link',
	),
	'file' => array(
		'icon' => 'clip',
	),
	'video' => array(
		'icon' => 'video',
	),
);

$tabs = array();
foreach ($plugins as $plugin => $options) {
	if (!elgg_is_active_plugin($plugin)) {
		continue;
	}

	$tabs[] = array(
		'text' => elgg_view_icon($options['icon']) . elgg_echo("activity:add:$plugin"),
		'href' => "#",
		'class' => null,
		'data-type' => $plugin,
	);
}

$tabs = elgg_view('navigation/tabs', array(
	'class' => 'elgg-activity-tabs',
	'tabs' => $tabs,
));

echo "<div id=\"elgg-activity-create\">$tabs<div id=\"elgg-activity-create-form\"></div></div>";
