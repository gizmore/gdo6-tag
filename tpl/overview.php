<?php
use GDO\Template\GDO_Box;

echo $navbar->render();
echo GDO_Box::make()->html(t('box_content_tags_overview'))->render();
