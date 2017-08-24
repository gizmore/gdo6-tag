<?php
namespace GDO\Tag;

use GDO\DB\GDO_Object;

class GDO_Tag extends GDO_Object
{
	public function __construct()
	{
		$this->table(Tag::table());
		$this->completionHref(href('Tag', 'CompleteTag'));
	}
	
	/**
	 * @return Tag;
	 */
	public function getTag()
	{
	    return $this->getValue();
	}
	
	public function displayName()
	{
	    return $this->getTag()->displayName();
	}
		
	public function defaultLabel()
	{
		return $this->label('tag');
	}
}
