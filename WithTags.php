<?php
namespace GDO\Tag;

use GDO\DB\Cache;

/**
 * To make your GDO taggable:
 * 1. Your taggable GDO shall "use WithTags";
 * 2. Create a Table/GDO for tag relations. Your GDOTagTable extends GDO_TagTable.
 * 3. Implement the function gdoTagTable() in your taggable. E.g. return YourGDOTagTable::table();
 * 
 * To allow editing tags in a form:
 * 1. Add a GDT_Tags::make() to your GDO columns.
 * @see GDT_Tags
 * 
 * To display a tag cloud use GDT_TagCloud.
 * @see GDT_TagCloud
 * 
 * @author gizmore
 * @version 6.10
 * @since 6.03
 */
trait WithTags
{
	### Abstract
	#public function gdoTagTable() { return YourGDOTagTable::table(); }
    
	###########
	### Get ###
	###########
	/**
	 * Get all tags for this object.
	 * @return \GDO\Tag\GDO_Tag[]
	 */
	public function getTags()
	{
	    return GDO_Tag::forObject($this);
	}
	
	##############
	### Update ###
	##############
	public function updateTags(array $newTags)
	{
		$table = $this->gdoTagTable();
		$table instanceof GDO_TagTable;
		
		$oldTags = array_keys($this->getTags());

		$new = array_diff($newTags, $oldTags);
		$deleted = array_diff($oldTags, $newTags);
		$all = GDO_Tag::table()->all();
		foreach ($new as $tagName)
		{
			if (!($tag = (@$all[$tagName])))
			{
			    $tag = GDO_Tag::blank(['tag_name'=>$tagName])->insert();
				$all[$tagName] = $tag;
			}
			else
			{
				$tag->increase('tag_count');
			}
			$table->blank(['tag_tag'=>$tag->getID(), 'tag_object'=>$this->getID()])->replace();
		}
		foreach ($deleted as $tagName)
		{
			if ($tag = (@$all[$tagName]))
			{
				$tag->increase('tag_count', -1);
			}
		}
		
		# Store new cache
		$tags = [];
		foreach ($newTags as $tagName)
		{
			$tags[$tagName] = $all[$tagName];
		}
		$this->tempSet('gdo_tags', $tags);
		$this->table()->tempUnset('gdo_tags');
		$this->recache();
		Cache::set('gdo_tags', $all);
		Cache::heat('gdo_tags', $tags);
	}
}
