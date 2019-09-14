<?php
use GDO\Tag\GDT_Tags;
$field instanceof GDT_Tags;
foreach ($field->gdo->getTags() as $tag)
{
	echo $tag->displayName();
}
