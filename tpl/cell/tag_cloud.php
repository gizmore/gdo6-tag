<?php
use GDO\Tag\GDT_TagCloud;
$field instanceof GDT_TagCloud;
$filterValue = $field->filterValue();
?>
<div class="gdo-tag-cloud">
<?php foreach ($field->getTags() as $tag) : ?>
  <a
   href="<?= $field->hrefTagFilter($tag); ?>"
   class="<?= $filterValue === $tag->getID() ? 'gdo-selected' : ''; ?>">
    <span><?= $tag->displayName(); ?>(<?= $tag->getCount(); ?>)</span>
 </a>
<?php endforeach; ?>
  <input type="hidden" name="f[<?= $field->name; ?>]" value="<?= html($filterValue); ?>" />
</div>