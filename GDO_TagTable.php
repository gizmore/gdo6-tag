<?php
namespace GDO\Tag;

use GDO\DB\GDO;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_Object;
use GDO\Core\ModuleLoader;

class GDO_TagTable extends GDO
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
			GDT_Object::make('tag_tag')->table(GDO_Tag::table()),
			GDT_TagTable::make('tag_object')->table($this->gdoTagObjectTable()),
			GDT_CreatedBy::make('tag_created_by'),
			GDT_CreatedAt::make('tag_created_at'),
		);
	}
	
	public function allObjectTags()
	{
		$table = $this->gdoTagObjectTable();
		if (!($cache = $table->tempGet('gdo_tags')))
		{
			$cache = $this->select('tag_name, tag_id, COUNT(*) tag_count')->joinObject('tag_tag')->group('tag_id')->exec()->fetchAllArray2dObject(GDO_Tag::table());
			$table->tempSet('gdo_tags', $cache);
		}
		return $cache;
	}
	
	/**
	 * @return self[]
	 */
	public static function allTagTables()
	{
		$tables = [];
		foreach (ModuleLoader::instance()->getModules() as $module)
		{
			if ($classes = $module->getClasses())
			{
				foreach ($classes as $className)
				{
					if (is_subclass_of($className, 'GDO\Tag\GDO_TagTable'))
					{
						$tables[] = GDO::tableFor($className);
					}
				}
			}
		}
		return $tables;
	}
}
