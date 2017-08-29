<?php
namespace GDO\Tag;
use GDO\DB\WithObject;
use GDO\Template\GDT_Template;
use GDO\DB\Query;
class GDT_TagCloud extends GDT_Template
{
	use WithObject;
	
	public function __construct()
	{
		$this->template('Tag', 'cell/tag_cloud.php', ['field'=>$this]);
	}
	
	/**
	 * @return Tag[]
	 */
	public function getTags()
	{
		return $this->getTagTable()->allObjectTags();
	}
	
	/**
	 * @return TagTable
	 */
	public function getTagTable()
	{
		return $this->table->gdoTagTable();
	}
	
	##############
	### Filter ###
	##############
	public function filterQuery(Query $query)
	{
		if ($filterId = $this->filterValue())
		{
			$tagtable = $this->getTagTable();
			$objtable = $this->table;
			$query->join("JOIN {$tagtable->gdoTableIdentifier()} ON tag_tag={$filterId} AND tag_object={$objtable->gdoPrimaryKeyColumn()->identifier()}");
		}
		return $query;
	}
	
	
	public function hrefTagFilter(Tag $tag)
	{
		$name = $this->name;
		$url = preg_replace("/&f\\[$name\\]=\d+/", '', $_SERVER['REQUEST_URI']);
		$url = preg_replace("/&page=\d+/", '', $url);
		return $url . "&f[$name]=" . $tag->getID(); 
	}
}
