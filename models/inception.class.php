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
			die('cannot hydrate without PK value '.$this->table_name);

		$query = "SELECT * FROM ".$this->table_name." WHERE ".$this->pk." =".$this->{$this->pk};
		$item = myFetchAssoc($query);

		foreach ($item as $field => $value)
		{
			$this->$field = $value;
		}
	}

	public function save()
	{
		if ($this->{$this->pk} == null)
			die('cannot hydrate without PK value');
	}

	// public function select_all_query($table_name, $id) {
	// 	if (empty($table_name)) {
	// 		if(empty($id)) {
	// 			return $query = "SELECT * FROM ".$this->table_name;
	// 		} else {
	// 			return $query = "SELECT * FROM "..
	// 		}
	// 	}
	// 	$query = "SELECT * FROM ".$table_name." WHERE ";
	// 	foreach ($fields as $field) {
  //
	// 	}
	// }

	// Test insert générique avec prepare / execute
	// public function getColumnTypes()
	// {
	// 	$data_types = [];
	// 	if($data_types = myColumnDataTypes($table_name))
	// 		return $data_types;
	// }


}
