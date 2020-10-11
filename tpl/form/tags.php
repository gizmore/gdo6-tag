<?php /** @var $field \GDO\Tag\GDT_Tags **/ ?>
<div class="gdo-container<?= $field->classError(); ?>">
  <?= $field->htmlIcon(); ?>
  <label for="form[<?= $field->name; ?>]"><?= $field->displayLabel(); ?></label>
  <div>
<?php $comma = ''; ?>
<?php foreach ($field->tagtable->allObjectTags() as $tagName => $tagObj) : ?>
  <?php printf('%s%s(%d)', $comma, $tagObj->display('tag_name'), $tagObj->getVar('tag_count')); ?>
  <?php if (!$comma) $comma = ', '; ?>
<?php endforeach; ?>
  </div>
  <input
   type="text"
   name="form[<?= $field->name; ?>]"
   size="64"
   <?= $field->htmlDisabled(); ?>
   <?= $field->htmlRequired(); ?>
   value="<?= $field->displayVar(); ?>" />
  <?= $field->htmlError(); ?>
</div>
