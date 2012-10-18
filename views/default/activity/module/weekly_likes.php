<?php
/**
 * Display a list of the most liked contents within a week.
 */

$week_ago = time() - (60 * 60 * 24 * 7);

elgg_push_context('widgets');
$likes = elgg_list_entities_from_annotations(array(
	'annotation_names' => 'likes',
	'order_by_annotation' => 'likes',
	'full_view' => false,
	'pagination' => false,
	'wheres' => array("n_table.time_created > $week_ago"),
));
elgg_pop_context();

if ($likes) {
	echo elgg_view_module('aside', elgg_echo('activity:module:weekly_likes'), $likes);
}
