<?php
class View {
	private $actualView;
	
	function __construct() {
		$this->actualView = $this->standard();
	}
		
	function standard() {
		global $DB_LOCA,$DB_USER,$DB_PASS,$DB_NAME;
		$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
		if (!$connect)
		{
		   header("Location: /".$PG_LOCA."error.php?error=Could not connect to the Database.");
		}

		mysql_select_db($DB_NAME, $connect);
		$query = mysql_query("SELECT name FROM views WHERE standard='1' ORDER BY name");
		$objResult = mysql_fetch_object($query);
		mysql_free_result($query);

		mysql_close($connect);
		return $objResult->name;
	}
	
	function setView($viaw) {
		$this->actualView = $viaw;
	}
	
	function getView() {
		return $this->actualView;
	}
	
	function getSelects() {
		global $DB_LOCA,$DB_USER,$DB_PASS,$DB_NAME;
		$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
		if (!$connect)
		{
		   header("Location: /".$PG_LOCA."error.php?error=Could not connect to the Database.");
		}

		mysql_select_db($DB_NAME, $connect);
	
		$query = mysql_query("SELECT * FROM views ORDER BY name");
		$reta = "";
		while ($objResult = mysql_fetch_object($query)) {
			$selected = "";
			if($objResult->name==$this->actualView) { $selected =  ' selected'; }
			$reta = $reta."<option value='".$objResult->name."'".$selected.">".ucwords($objResult->name)."</option>";
		}
		
		mysql_free_result($query);

		mysql_close($connect);
		
		return $reta;
	}
}
?>