<?php
namespace GDO\Tag;

use GDO\Core\Application;
use GDO\DB\GDO;
use GDO\DB\GDO_CreatedAt;
use GDO\DB\GDO_CreatedBy;
use GDO\DB\GDO_Object;
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
			GDO_Object::make('tag_tag')->table(Tag::table()),
			GDO_TagTable::make('tag_object')->table($this->gdoTagObjectTable()),
			GDO_CreatedBy::make('tag_created_by'),
			GDO_CreatedAt::make('tag_created_at'),
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
