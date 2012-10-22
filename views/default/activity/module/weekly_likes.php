<?php
/**
 * Display a list of the most liked contents within a week.
 */

$week_ago = time() - (60 * 60 * 24 * 7);

// Get less than week old entities ordered by amount of likes
$likes = elgg_get_entities_from_annotation_calculation(array(
	'annotation_names' => 'likes',
	'calculation' => 'count', 
	'wheres' => array("n_table.time_created > $week_ago"),
));

// We must use a customized list view since there is no standard for list items in widget context
if ($likes) {
	$entities = array();
	foreach ($likes as $entity) {
		$entities[$entity->getGUID()] = $entity->countAnnotations('likes');
	}
	sort($entities);
	$ordered_likes = array();
	foreach ($entities as $guid => $likes_count) {
		$ordered_likes[] = $likes[$guid];
	}
	$likes = $ordered_likes;
	
	$html .= '<ul class="elgg-list">';
	foreach ($likes as $entity) {
		if (elgg_instanceof($entity)) {
			$id = "elgg-{$entity->getType()}-{$entity->getGUID()}";
		} else {
			$id = "item-{$entity->getType()}-{$entity->id}";
		}
		$html .= "<li id=\"$id\" class=\"elgg-item\">";
		$html .= elgg_view('activity/entity', array('entity' => $entity));
		$html .= '</li>';
	}
	$html .= '</ul>';

	echo elgg_view_module('aside', elgg_echo('activity:module:weekly_likes'), $html);
}
