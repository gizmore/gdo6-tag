<?php
use GDO\Table\GDT_Table;
use GDO\Tag\Module_Tag;
use GDO\Tag\GDO_Tag;
use GDO\UI\GDT_Button;
use GDO\User\GDO_User;

$user = GDO_User::current();
$module = Module_Tag::instance();
echo $module->renderAdminTabs();

$gdo = GDO_Tag::table();
$query = $gdo->select('*');

$table = GDT_Table::make();
$table->addFields($gdo->gdoColumnsCache());
$table->addField(GDT_Button::make('edit'));
$table->filtered();
$table->paginateDefault();
$table->query($query);
$table->href(href('Tag', 'AdminOverview'));

echo $table->render();
