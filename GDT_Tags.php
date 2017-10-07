<?php
namespace GDO\Tag;

use GDO\Core\GDT;
use GDO\Core\GDT_Template;
use GDO\UI\WithIcon;
use GDO\Form\WithFormFields;
use GDO\UI\WithLabel;

/**
 * A tag form input field.
 * Updates an objects tagdata upon create and update.
 * @author gizmore
 * @since 3.00
 * @version 6.05
 */
final class GDT_Tags extends GDT
{
    use WithIcon;
    use WithLabel;
    use WithFormFields;
    
    public $initial = '[]';
    
    ################
    ### TagTable ###
    ################
    /**
     * Mandatory.
     * The tagtable backing this tags input.
     * @var \GDO\Tag\GDO_TagTable
     */
    public $tagtable;
    public function tagtable(GDO_TagTable $tagtable) { $this->tagtable = $tagtable; return $this; }
    
	#############
	### Event ###
	#############
	public function gdoAfterCreate() { $this->updateTags(); }
	public function gdoAfterUpdate() { $this->updateTags(); }
	public function updateTags() { $this->gdo->updateTags($this->getValue()); }
	
	#############
	### Value ###
	#############
	public function toValue($var)
	{
		if ($var[0] === '[')
		{
			return ($tags = @json_decode($var)) ? $tags : [];
		}
		return array_map(function($a){return trim($a);}, explode(',', $var));
	}
	public function toVar($value) { return json_encode(array_values($value)); }
	
	################
	### Max Tags ###
	################
	public $maxTags = 10;
	public function maxTags($maxTags) { $this->maxTags = $maxTags; return $this; }
	
	##############
	### Render ###
	##############
	public function renderCell() { return GDT_Template::php('Tag', 'cell/tags.php', ['field' => $this]); }
	public function renderForm() { return GDT_Template::php('Tag', 'form/tags.php', ['field' => $this]); }
	public function renderJSON()
	{
		return array(
		    'all' => array_keys(GDO_Tag::table()->all()),
			'tags' => $this->getValue(),
		);
	}
	
	################
	### Validate ###
	################
	public function validate($tags)
	{
		if (count($tags) > $this->maxTags)
		{
			return $this->error('err_max_tags', [$this->maxTags]);
		}

		$namefield = GDT_TagName::make();
		foreach ($tags as $tagName)
		{
			if (!$namefield->validate($tagName))
			{
				return $this->error('err_tag_name', [htmlspecialchars($tagName)]);
			}
		}
		
		return true;
	}
}
