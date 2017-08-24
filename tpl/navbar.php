<?php
use GDO\Template\GDO_Bar;
use GDO\UI\GDO_Link;

$navbar = GDO_Bar::make();
$navbar->addFields(array(
	GDO_Link::make('link_tags')->href(href('Tag', 'AdminTags')),
	GDO_Link::make('link_untagged')->href(href('Tag', 'AdminTags')),
	GDO_Link::make('link_tagged_tables')->href(href('Tag', 'AdminTags')),
));
echo $navbar->renderCell();
