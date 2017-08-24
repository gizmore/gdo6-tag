<?php
use GDO\Template\GDO_Bar;
use GDO\UI\GDO_Link;

$bar = GDO_Bar::make();
$bar->addField(GDO_Link::make('link_tag_overview'));
echo $bar->render();
