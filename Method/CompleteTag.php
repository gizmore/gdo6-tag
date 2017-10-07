<?php
namespace GDO\Tag\Method;

use GDO\Core\MethodCompletion;
use GDO\Tag\GDO_Tag;

final class CompleteTag extends MethodCompletion
{
	public function execute()
	{
		$q = $this->getSearchTerm();
		$max = $this->getMaxSuggestions();
		$result = [];
		foreach (GDO_Tag::table()->all() as $tag)
		{
			if ( (!$q) || (mb_stripos($tag->getName(), $q)!==false) )
			{
				$result[] = array(
					'id' => $tag->getID(),
					'text' => $tag->displayName(),
					'display' => $tag->renderCell(),
				);
			}
			if (count($result) > $max)
			{
				break;
			}
		}
		die(json_encode($result));
	}
}
