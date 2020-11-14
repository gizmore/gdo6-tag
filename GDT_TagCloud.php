<?php
namespace GDO\Tag;

use GDO\DB\WithObject;
use GDO\Core\GDT_Template;
use GDO\DB\Query;

/**
 * Render a tag cloud.
 * 
 * @author gizmore
 * @version 6.10
 * @since 6.04
 * 
 * @see WithTags
 * @see GDT_Tag
 * @see GDO_Tag
 * @see GDO_TagTable
 */
class GDT_TagCloud extends GDT_Template
{
	use WithObject;
	
	public function __construct()
	{
		$this->template('Tag', 'cell/tag_cloud.php', ['field'=>$this]);
	}
	
	/**
	 * @return GDO_Tag[]
	 */
	public function getTags()
	{
		return $this->getTagTable()->allObjectTags();
	}
	
	/**
	 * @return GDO_TagTable
	 */
	public function getTagTable()
	{
		return $this->table->gdoTagTable();
	}
	
	###################
	### Total count ###
	###################
	public $totalCountCondition = '1';
	public function totalCountCondition($totalCountCondition)
	{
	    $this->totalCountCondition = $totalCountCondition;
	    return $this;
	}
	
	public function totalCount()
	{
	    return $this->table->countWhere($this->totalCountCondition);
	}
	
	##############
	### Filter ###
	##############
	public $filterName = 'f';
	public function filterName($filterName)
	{
	    $this->filterName = $filterName;
	    return $this;
	}
	
	public function filterQuery(Query $query, $rq=null)
	{
		if ($filterId = $this->filterVar($rq))
		{
			$tagtable = $this->getTagTable();
			$objtable = $this->table;
			$query->join("JOIN {$tagtable->gdoTableIdentifier()} ON tag_tag={$filterId} AND tag_object={$objtable->gdoPrimaryKeyColumn()->identifier()}");
		}
		return $query;
	}
	
	
	public function hrefTagFilter(GDO_Tag $tag=null)
	{
		$name = $this->name;
		$f = $this->filterName;
		$url = preg_replace("/&$f\\[$name\\]=\d+/", '', @$_SERVER['REQUEST_URI']);
		$url = preg_replace("/&page=\d+/", '', $url);
		if ($tag)
		{
		    $url .= "&{$f}[$name]=" . $tag->getID();
		}
		return $url;
	}

}
