<?php
use GDO\Tag\GDT_TagCloud;
/** @var $field GDT_TagCloud **/
$filterValue = $field->filterValue();
?>
<div class="gdo-tag-cloud">
  <a
   href="<?= $field->hrefTagFilter(); ?>"
   class="<?= $filterValue === '0' ? 'gdo-selected' : ''; ?>">
    <span><?= t('all'); ?>(<?= $field->totalCount(); ?>)</span>
 </a>
<?php foreach ($field->getTags() as $tag) : ?>
  <a
   href="<?= $field->hrefTagFilter($tag); ?>"
   class="<?= $filterValue === $tag->getID() ? 'gdo-selected' : ''; ?>">
    <span><?= $tag->displayName(); ?>(<?= $tag->getCount(); ?>)</span>
 </a>
<?php endforeach; ?>
  <input type="hidden" name="f[<?= $field->name; ?>]" value="<?= html($filterValue); ?>" />
</div>
