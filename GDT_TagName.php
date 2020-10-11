<?php
namespace GDO\Tag;

use GDO\DB\GDT_String;

class GDT_TagName extends GDT_String
{
	public function __construct()
	{
		$this->min = 2;
		$this->max = 28;
		$this->caseI();
		$this->pattern = "/^[a-z0-9][-_a-z0-9]{1,27}$/i";
	}
}
