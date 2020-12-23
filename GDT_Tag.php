<?php
namespace GDO\Tag;

use GDO\DB\GDT_Object;

class GDT_Tag extends GDT_Object
{
	protected function __construct()
	{
// 	    parent::__construct();
	    $this->icon('tag');
	    $this->table(GDO_Tag::table());
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
