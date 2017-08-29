<?php
use GDO\Template\GDT_Box;

echo $navbar->render();
echo GDT_Box::make()->html(t('box_content_tags_overview'))->render();
