<?php
use GDO\Tag\GDO_TagCloud;
$field instanceof GDO_TagCloud;
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
  <input type="hidden" name="f[<?= $field->name; ?>]" value="<?= $field->displayFilterValue(); ?>" />
</div>