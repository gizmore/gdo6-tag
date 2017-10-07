<?php
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;
$navbar = GDT_Bar::make();
$navbar->addFields(array(
	GDT_Link::make('link_tags')->href(href('Tag', 'AdminTags')),
	GDT_Link::make('link_untagged')->href(href('Tag', 'AdminTags')),
	GDT_Link::make('link_tagged_tables')->href(href('Tag', 'AdminTags')),
));
echo $navbar->render();
