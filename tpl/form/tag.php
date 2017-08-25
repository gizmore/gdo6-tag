<?php
use GDO\Tag\GDO_Tags;
$field instanceof GDO_Tags;
$id = 'gwftag_'.$field->name; ?>
<md-input-container
 class="md-block md-float md-icon-left<?= $field->classError(); ?>" flex
 ng-controller="GDOTagCtrl"
 ng-init='init("#<?= $id; ?>", <?= $field->renderJSON(); ?>)'>
  <label for="form[<?= $field->name; ?>]"><?= $field->label; ?></label>
  <?= $field->htmlIcon(); ?>
  <md-chips
   ng-model="tags"
   md-on-add="onChange()"
   md-on-remove="onChange()"
   md-removable="removable"
   md-add-on-blur="true"
   md-max-chips="<?= $field->maxTags; ?>"
   readonly="<?= $field->writable?'false':'true'; ?>"
   <?= $field->htmlRequired(); ?>
   placeholder="<?= $field->label; ?>">
   <md-autocomplete
    md-search-text="searchText"
    md-items="item in completeTags(searchText)">
   <md-item-template>
     <div md-highlight-text="searchText" md-highlight-flags="^i">{{item}}</div>
   </md-item-template>
   </md-autocomplete>
  </md-chips>
  <input
   type="hidden"
   id="<?= $id; ?>"
   name="form[<?= $field->name; ?>]"
   value="<?= $field->displayVar(); ?>"
   <?= $field->htmlDisabled(); ?>/>
  <div class="gdo-form-error"><?= $field->error; ?></div>
</md-input-container>

