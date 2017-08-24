<?php
namespace GDO\Tag;

use GDO\DB\Cache;

trait WithTags
{
	public function getTags()
	{
		return Tag::forObject($this);
	}
	
	public function updateTags(array $newTags)
	{
		$table = $this->gdoTagTable();
		$table instanceof TagTable;
		
		$oldTags = array_keys($this->getTags());

		$new = array_diff($newTags, $oldTags);
		$deleted = array_diff($oldTags, $newTags);
		$all = Tag::table()->all();
		foreach ($new as $tagName)
		{
			if (!($tag = (@$all[$tagName])))
			{
				$tag = Tag::blank(['tag_name'=>$tagName])->insert();
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
		$this->tempSet('gwf_tags', $tags);
		$this->table()->tempUnset('gwf_tags');
// 		$this->recache();
		Cache::set('gwf_tags', $all);
	}
}
