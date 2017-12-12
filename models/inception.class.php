<?php

Class Inception
{
	protected $pk = null;
	protected $table_name = null;
	protected $fields = [];

	public function __get($attr_name)
	{
		if (in_array($attr_name, $this->fields))
			return $this->$attr_name;
	}

	public function __set($attr_name, $attr_value)
	{
		if (in_array($attr_name, $this->fields))
			$this->$attr_name = $attr_value;
	}

	public function hydrate()
	{
		if ($this->{$this->pk} == null)
			die('cannot hydrate without PK value');

		$query = "SELECT * FROM ".$this->table_name." WHERE ".$this->pk." =".$this->{$this->pk};
		$item = myFetchAssoc($query);
		 
		foreach ($item as $field => $value)
		{
			$this->$field = $value;
		}
	}
}