<?php
namespace GDO\Tag;

use GDO\Core\GDT;
use GDO\Core\GDT_Template;
use GDO\UI\WithIcon;
use GDO\Form\WithFormFields;
use GDO\UI\WithLabel;
use GDO\Util\Arrays;

/**
 * A tag form input field.
 * Updates an objects tagdata upon create and update.
 * 
 * @author gizmore
 * @version 6.10
 * @since 3.00
 * @see WithTags
 */
final class GDT_Tags extends GDT
{
    use WithIcon;
    use WithLabel;
    use WithFormFields;
    
    public function defaultLabel() { return $this->label('tags'); }
    
    protected function __construct()
    {
        parent::__construct();
        $this->icon = 'tag';
        $this->initial = [];
    }
    
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
		if (!empty($var))
		{
			if ($var[0] === '[')
			{
				$tags = ($tags = @json_decode($var)) ? $tags : [];
			}
			else
			{
				$tags = Arrays::explode($var);
			}
			return array_map(function($a){return trim($a);}, $tags);
		}
		return [];
	}
	
	public function toVar($value)
	{
	    if ($value !== null)
	    {
	        return json_encode(array_values($value));
	    }
	}
	
	####################
	### Min/Max Tags ###
	####################
	public $minTags = 0;
	public function minTags($minTags) { $this->minTags = $minTags; return $this; }
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
			'tags' => $this->gdo ? array_values(array_map(function($tag){return $tag->getName();}, $this->gdo->getTags())) : $this->getValue(),
		);
	}
	
	################
	### Validate ###
	################
	public function validate($tags)
	{
		# Have to pass null check
		if (parent::validate($tags))
		{
			# Has to be array
			if (is_array($tags))
			{
				# Check forced tag count
				if (count($tags) < $this->minTags)
				{
					return $this->error('err_min_tags', [$this->minTags]);
				}
				if (count($tags) > $this->maxTags)
				{
					return $this->error('err_max_tags', [$this->maxTags]);
				}
				
				# Check individual tags
				$namefield = GDT_TagName::make();
				foreach ($tags as $tagName)
				{
					if (!$namefield->validate($tagName))
					{
						return $this->error('err_tag_name', [htmlspecialchars($tagName)]);
					}
				}
				# winner winner
			}
			else
			{
				return $this->error('err_tags_not_an_array');
			}
			# chicken dinner
			return true;
		}
	}
	
	public function renderHeader() { return $this->displayLabel(); }
	
	public function renderFilter($f)
	{
		return GDT_Template::php('Tag', 'filter/tags.php', ['field' => $this, 'f' => $f]);
	}
	
}
