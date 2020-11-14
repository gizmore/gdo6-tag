<?php
use GDO\Tag\GDT_TagCloud;
/** @var $field GDT_TagCloud **/
$filterVar = $field->filterVar();
?>
<div class="gdo-tag-cloud">
  <a
   href="<?= $field->hrefTagFilter(); ?>"
   class="<?= $filterVar === '0' ? 'gdo-selected' : ''; ?>">
    <span><?= t('all'); ?>(<?= $field->totalCount(); ?>)</span>
 </a>
<?php foreach ($field->getTags() as $tag) : ?>
  <a
   href="<?= $field->hrefTagFilter($tag); ?>"
   class="<?= $filterVar === $tag->getID() ? 'gdo-selected' : ''; ?>">
    <span><?= $tag->displayName(); ?>(<?= $tag->getCount(); ?>)</span>
 </a>
<?php endforeach; ?>
  <input type="hidden" name="f[<?= $field->name; ?>]" value="<?= html($filterVar); ?>" />
</div>
