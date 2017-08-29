<?php
namespace GDO\Tag;

use GDO\Core\Application;
use GDO\DB\GDO;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_Object;
use GDO\Core\ModuleLoader;

class TagTable extends GDO
{
	/**
	 * @return GDO
	 */
	public function gdoTagObjectTable() {}

	public function gdoCached() { return false; }
	public function gdoAbstract() { return $this->gdoTagObjectTable() === null; }
	public function gdoColumns()
	{
		return array(
			GDT_Object::make('tag_tag')->table(Tag::table()),
			GDT_TagTable::make('tag_object')->table($this->gdoTagObjectTable()),
			GDT_CreatedBy::make('tag_created_by'),
			GDT_CreatedAt::make('tag_created_at'),
		);
	}
	
	public function allObjectTags()
	{
		$table = $this->gdoTagObjectTable();
		if (!($cache = $table->tempGet('gwf_tags')))
		{
			$cache = $this->select('tag_name, tag_id, COUNT(*) tag_count')->joinObject('tag_tag')->group('tag_id')->exec()->fetchAllArray2dObject(Tag::table());
			$table->tempSet('gwf_tags', $cache);
		}
		return $cache;
	}
	
	/**
	 * @return TagTable[]
	 */
	public static function allTagTables()
	{
		$tables = [];
		foreach (ModuleLoader::instance()->getActiveModules() as $module)
		{
			if ($classes = $module->getClasses())
			{
				foreach ($classes as $className)
				{
					if (is_subclass_of($className, 'GDO\Tag\TagTable'))
					{
						$tables[] = GDO::tableFor($className);
					}
				}
			}
		}
		return $tables;
	}
}
