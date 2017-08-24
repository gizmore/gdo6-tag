<?php
namespace GDO\Tag;

use GDO\Type\GDO_String;

class GDO_TagName extends GDO_String
{
	public function __construct()
	{
		$this->min = 1;
		$this->max = 28;
		$this->pattern = "/^[a-z0-9]{1,28}$/i";
	}
}