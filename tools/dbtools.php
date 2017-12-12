<?php
	require_once("../config/config.php");


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
?>
