<?php

$entity = $vars['entity'];
$user = get_user($entity->owner_guid);
if (!$entity || !$user) {
	return true;
}

$user_icon = elgg_view_entity_icon($user, 'tiny');
$user_link = "<a href=\"{$user->getURL()}\">$user->name</a>";

$entity_title = $entity->title ? $entity->title : elgg_echo('untitled');
$entity_link = "<a href=\"{$entity->getURL()}\">$entity_title</a>";
$entity_type = elgg_echo("{$entity->getSubtype()}:{$entity->getSubtype()}");

$by = elgg_echo('byline', array($user_link));

$count = elgg_view('likes/count', array('entity' => $entity));

$body = <<<HTML
<span class="elgg-subtext">
	$entity_type $entity_link $by ($count)
</span>
HTML;

echo elgg_view_image_block($user_icon, $body);