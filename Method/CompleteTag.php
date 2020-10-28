<?php
namespace GDO\Tag\Method;

use GDO\Core\GDO;
use GDO\Tag\GDO_Tag;
use GDO\Core\MethodCompletionSearch;

final class CompleteTag extends MethodCompletionSearch
{
    public function gdoTable()
    {
        return GDO_Tag::table();
    }

    public function gdoHeaderColumns()
    {
        return ['tag_name'];
    }
    
    public function renderJSON(GDO $gdo)
    {
        return array(
            'id' => $gdo->getID(),
            'text' => $gdo->displayName(),
            'display' => $gdo->renderCell(),
        );
    }

}
