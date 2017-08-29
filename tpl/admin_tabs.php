<?php
use GDO\Template\GDT_Bar;
use GDO\UI\GDT_Link;

$bar = GDT_Bar::make();
$bar->addField(GDT_Link::make('link_tag_overview'));
echo $bar->render();
