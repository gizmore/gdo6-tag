<?php
namespace GDO\Tag;

use GDO\DB\Cache;
use GDO\DB\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\Template\GDT_Template;
use GDO\Type\GDT_Int;

final class GDO_Tag extends GDO
{
	public function memCached() { return false; }
	
	public function gdoColumns()
	{
		return array(
			GDT_AutoInc::make('tag_id'),
			GDT_TagName::make('tag_name')->notNull()->unique(),
			GDT_Int::make('tag_count')->unsigned()->notNull()->initial('1')->writable(false),
		);
	}
	
	public function getID() { return $this->getVar('tag_id'); }
	public function getName() { return $this->getVar('tag_name'); }
	public function getCount() { return $this->getVar('tag_count'); }
	
	public function displayName() { return $this->getName(); }
	public function renderCell() { return GDT_Template::php('Tag', 'cell/tag.php', ['field' => $this]); }
	
	public function href_edit() {return href('Tag', 'AdminEdit', '&id='.$this->getID()); }
	
	##############
	### Static ###
	##############
	/**
	 * @return self[]
	 */
	public function all()
	{
		if (!($cache = Cache::get('gdo_tags')))
		{
		    $cache = self::table()->select('tag_name, tag_id, tag_count')->exec()->fetchAllArrayAssoc2dObject();
			Cache::set('gdo_tags', $cache);
		}
		return $cache;
	}
	
	/**
	 * 
	 * @param GDO $gdo
	 * @return self[]
	 */
	public static function forObject(GDO $gdo=null)
	{
		if ($gdo)
		{
			if (!($cache = $gdo->tempGet('gdo_tags')))
			{
				$tags = $gdo->gdoTagTable();
				$tags instanceof GDO_TagTable;
				$cache = $tags->select('tag_name, tag_id, tag_count')->joinObject('tag_tag')->where("tag_object=".$gdo->getID())->exec()->fetchAllArray2dObject(self::table());
				$gdo->tempSet('gdo_tags', $cache);
			}
			return $cache;
		}
		return [];
	}
}
