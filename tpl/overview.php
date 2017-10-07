<?php
use GDO\UI\GDT_Panel;

echo $navbar->render();
echo GDT_Panel::make()->html(t('box_content_tags_overview'))->render();
