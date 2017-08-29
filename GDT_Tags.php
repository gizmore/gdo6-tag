<?php
namespace GDO\Tag;
use GDO\Type\GDT_Base;
use GDO\Template\GDT_Template;
use GDO\Form\WithIcon;
use GDO\Form\WithFormFields;
use GDO\UI\WithLabel;

final class GDT_Tags extends GDT_Base
{
    use WithIcon;
    use WithLabel;
    use WithFormFields;
    
	public function __construct()
	{
		$this->initial = '[]';
	}
	
	public function toValue($var)
	{
		return ($tags = @json_decode($var)) ? $tags : [];
	}
	
	public function toVar($value)
	{
		return json_encode(array_values($value));
	}
	
	################
	### Max Tags ###
	################
	public $maxTags = 10;
	public function maxTags(int $maxTags)
	{
		$this->maxTags = $maxTags;
		return $this;
	}
	
	##############
	### Render ###
	##############
	public function renderForm()
	{
		return GDT_Template::php('Tag', 'form/tag.php', ['field' => $this]);
	}
	
	public function renderCell()
	{
	    return GDT_Template::php('Tags', 'cell/tag.php', ['field' => $this]);
	}
	
	public function toJSON()
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
