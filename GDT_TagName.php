<?php
namespace GDO\Tag;

use GDO\Type\GDT_String;

class GDT_TagName extends GDT_String
{
	public function __construct()
	{
		$this->min = 1;
		$this->max = 28;
		$this->pattern = "/^[a-z0-9]{1,28}$/i";
	}
}