<?php
namespace GDO\Tag;

use GDO\Core\Module;

final class Module_Tag extends Module
{
	public $module_priority = 40;
	public function onLoadLanguage() { $this->loadLanguage('lang/tags'); }
	public function getClasses() { return ['GDO\Tag\Tag']; }
	
	public function onIncludeScripts()
	{
		$this->addJavascript('js/gwf-tag-ctrl.js');
	}
	
	public function href_administrate_module() { return href('Tag', 'AdminOverview'); }
	
	public function renderAdminTabs()
	{
		return $this->templatePHP('admin_tabs.php');
	}
	
	
	public function hookClearCache()
	{
// 		$query = Tag::table()->update()->set("tag_count=COUNT(*)")->where('true')->group('tag_id');
// 		foreach (Application::instance()->getActiveModules() as $module)
// 		{
// 			if ($classes = $module->getClasses())
// 			{
// 				foreach ($classes as $class)
// 				{
// 					if (is_subclass_of($class, 'TagTable'))
// 					{
// 						$table = GDO::tableFor($class);
// 						$query->join("RIGHT JOIN {$table->gdoTableIdentifier()} ON tag_tag=tag_id");
// 					}
// 				}
// 			}
// 		}
// 		$query->exec();
// 		Tag::table()->deleteWhere('tag_count=0')->exec();
	}
	
	##################
	### Top Navbar ###
	##################
	public function tagsNavbar()
	{
		return $this->templatePHP('navbar.php');
	}
}
