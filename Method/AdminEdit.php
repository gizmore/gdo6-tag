<?php
namespace GDO\Tag\Method;

use GDO\Core\Website;
use GDO\DB\Database;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\Tag\GDT_Tag;
use GDO\Tag\Module_Tag;
use GDO\Tag\GDO_Tag;
use GDO\Util\Common;
use GDO\Form\GDT_Validator;

final class AdminEdit extends MethodForm
{
	private $gdo;
	
	public function execute()
	{
		$this->gdo = GDO_Tag::table()->find(Common::getRequestString('id'));
		return Module_Tag::instance()->renderAdminTabs()->add(parent::execute());
	}
	
	public function createForm(GDT_Form $form)
	{
	    $tags = GDO_Tag::table();
		$form->addFields($tags->gdoColumnsCache());
		$form->addField(GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
		$form->actions()->addField(GDT_Submit::make('delete'));
		$form->actions()->addField(GDT_Submit::make('merge'));
		$form->addField(GDT_Tag::make('merge_tag'));
		$form->addField(GDT_Validator::make()->validator('merge_tag', [$this, 'validateMergeTarget']));
		$form->withGDOValuesFrom($this->gdo);
	}
	
	public function validateMergeTarget(GDT_Form $form, GDT_Tag $tag)
	{
		if (isset($_REQUEST['merge']))
		{
			if (!($other = $tag->getValue()))
			{
				return $tag->error('err_tag_merge_target_needed');
			}
			if ($other->getID() === $this->gdo->getID())
			{
				return $tag->error('err_tag_merge_target_self');
			}
		}
		return true;
	}
	
	public function formValidated(GDT_Form $form)
	{
		$this->gdo->saveVars($form->getFormData());
		return parent::formValidated($form);
	}
	
	public function onSubmit_merge(GDT_Form $form)
	{
// 		$mergeInto = $form->getField('merge_tag')->getValue();
		
// 		foreach (TagTable::allTagTables() as $tagTable)
// 		{
// 			foreach ($tagTable->allObjectsWithTag($this->gdo) as $object)
// 			{
// 				$tagTable
// 			}
// 		}
	}

	public function onSubmit_delete(GDT_Form $form)
	{
		$this->gdo->delete();
		$rows = Database::instance()->affectedRows();
		return $this->message('msg_tag_deleted', [$rows])->add(Website::redirectMessage(href('Tag', 'AdminOverview')));
	}

}
