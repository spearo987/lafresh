<?php
	require_once("./config/config.php");


	function	myQuery($query)
	{
		global $link;

		if (empty($link))
			$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die (mysqli_connect_error());
		$result = mysqli_query($link, $query) or die (mysqli_error($link));
		return $result;
	}

	function	myFetchAssoc($query)
	{
		global $link;

		$result = myQuery($query) or die (mysqli_error($link));
		if (!$result)
			return false;

		$tab_res = mysqli_fetch_assoc($result);
		return $tab_res;
	}

	function	myFetchAllAssoc($query)
	{
		global $link;

		$result = myQuery($query) or die (mysqli_error($link));
		if (!$result)
			return false;

		$tab_res = [];

		while ($array = mysqli_fetch_assoc($result))
			$tab_res[] = $array;
		return $tab_res;
	}

	function mySave($query)
	{
		global $link;

		$result = myQuery($query) or die (mysqli_error($link));

		if(!$result) {
			return false;
		}
		else {
			return true;
		}
	}

	function mySaveId($query)
	{
		global $link;

		$result = mySave($query) or die (mysqli_error($link));
	
		if(!$result) {
			return false;
		}
		else {
			return mysqli_insert_id($link);
		}
	}

	// Test insert générique avec prepare / execute
	// function myColumnDataTypes($table_name)
	// {
	// 	global $link;
  //
	// 	$query = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '".$table_name."'";
	// 	$tab_res = myFetchAssoc($query);
  //
	// 	return $tab_res;
	// }


?>
