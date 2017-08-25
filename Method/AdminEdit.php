<?php
namespace GDO\Tag\Method;

use GDO\Core\Website;
use GDO\DB\Database;
use GDO\Form\GDO_AntiCSRF;
use GDO\Form\GDO_Form;
use GDO\Form\GDO_Submit;
use GDO\Form\MethodForm;
use GDO\Tag\GDO_Tag;
use GDO\Tag\Module_Tag;
use GDO\Tag\Tag;
use GDO\Util\Common;
use GDO\Form\GDO_Validator;

final class AdminEdit extends MethodForm
{
	private $gdo;
	
	public function execute()
	{
		$this->gdo = Tag::table()->find(Common::getRequestString('id'));
		return Module_Tag::instance()->renderAdminTabs()->add(parent::execute());
	}
	
	public function createForm(GDO_Form $form)
	{
		$tags = Tag::table();
		$form->addFields($tags->gdoColumnsCache());
		$form->addField(GDO_AntiCSRF::make());
		$form->addField(GDO_Submit::make());
		$form->addField(GDO_Submit::make('delete'));
		$form->addField(GDO_Submit::make('merge'));
		$form->addField(GDO_Tag::make('merge_tag'));
		$form->addField(GDO_Validator::make()->validator('merge_tag', [$this, 'validateMergeTarget']));
		$form->withGDOValuesFrom($this->gdo);
	}
	
	public function validateMergeTarget(GDO_Form $form, GDO_Tag $tag)
	{
		if (isset($_POST['merge']))
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
	
	public function formValidated(GDO_Form $form)
	{
		$this->gdo->saveVars($form->getFormData());
		return parent::formValidated($form);
	}
	
	public function onSubmit_merge(GDO_Form $form)
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

	public function onSubmit_delete(GDO_Form $form)
	{
		$this->gdo->delete();
		$rows = Database::instance()->affectedRows();
		return $this->message('msg_tag_deleted', [$rows])->add(Website::redirectMessage(href('Tag', 'AdminOverview')));
	}

}