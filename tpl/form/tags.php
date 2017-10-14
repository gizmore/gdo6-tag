<?php /** @var $field \GDO\Tag\GDT_Tags **/ ?>
<div class="gdo-container<?= $field->classError(); ?>">
<?php foreach ($field->tagtable->allObjectTags() as $tagName => $tagObj) : ?>
  <?php printf('%s(%d)', html($tagName), 3); ?>
<?php endforeach; ?>
  <?= $field->htmlIcon(); ?>
  <label for="form[<?= $field->name; ?>]"><?= $field->label; ?></label>
  <input
   type="text"
   name="form[<?= $field->name; ?>]"
   size="64"
   <?= $field->htmlDisabled(); ?>
   <?= $field->htmlRequired(); ?>
   value="<?= $field->displayVar(); ?>" />
  <?= $field->htmlError(); ?>
</div>
