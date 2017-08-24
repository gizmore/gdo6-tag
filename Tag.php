<?php
namespace GDO\Tag;

use GDO\DB\Cache;
use GDO\DB\GDO;
use GDO\DB\GDO_AutoInc;
use GDO\Template\GDO_Template;
use GDO\Type\GDO_Int;

final class Tag extends GDO
{
	public function memCached() { return false; }
	
	public function gdoColumns()
	{
		return array(
			GDO_AutoInc::make('tag_id'),
			GDO_TagName::make('tag_name')->notNull()->unique(),
			GDO_Int::make('tag_count')->unsigned()->notNull()->initial('1')->writable(false),
		);
	}
	
	public function getID() { return $this->getVar('tag_id'); }
	public function getName() { return $this->getVar('tag_name'); }
	public function getCount() { return $this->getVar('tag_count'); }
	
	public function displayName() { return $this->getName(); }
	public function renderCell() { return GDO_Template::php('Tag', 'cell/tag.php', ['field' => $this]); }
	
	public function href_edit() {return href('Tag', 'AdminEdit', '&id='.$this->getID()); }
	
	##############
	### Static ###
	##############
	/**
	 * @return Tag[]
	 */
	public function all()
	{
		if (!($cache = Cache::get('gwf_tags')))
		{
			$cache = self::table()->select('tag_name, tag_id, tag_count')->exec()->fetchAllArray2dObject();
			Cache::set('gwf_tags', $cache);
		}
		return $cache;
	}
	
	/**
	 * 
	 * @param GDO $gdo
	 * @return Tag[]
	 */
	public static function forObject(GDO $gdo=null)
	{
		if ($gdo)
		{
			if (!($cache = $gdo->tempGet('gwf_tags')))
			{
				$tags = $gdo->gdoTagTable();
				$tags instanceof TagTable;
				$cache = $tags->select('tag_name, tag_id, tag_count')->joinObject('tag_tag')->where("tag_object=".$gdo->getID())->exec()->fetchAllArray2dObject(Tag::table());
				$gdo->tempSet('gwf_tags', $cache);
			}
			return $cache;
		}
		return [];
	}
}
