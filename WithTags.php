<?php
namespace GDO\Tag;

use GDO\DB\Cache;

trait WithTags
{
	public function getTags()
	{
	    return GDO_Tag::forObject($this);
	}
	
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
// 		$this->recache();
		Cache::set('gdo_tags', $all);
	}
}
