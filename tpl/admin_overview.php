<?php
use GDO\Table\GDO_Table;
use GDO\Tag\Module_Tag;
use GDO\Tag\Tag;
use GDO\UI\GDO_Button;
use GDO\User\User;

$user = User::current();
$module = Module_Tag::instance();
echo $module->renderAdminTabs();

$gdo = Tag::table();
$query = $gdo->select('*');

$table = GDO_Table::make();
$table->addFields($gdo->gdoColumnsCache());
$table->addField(GDO_Button::make('edit'));
$table->filtered();
$table->paginateDefault();
$table->query($query);
$table->href(href('Tag', 'AdminOverview'));

echo $table->render();
