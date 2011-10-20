<?php
class View {
	private $actualView;
	
	function __construct() {
		$this->actualView = $this->standard();
	}
		
	function standard() {
		$query = mysql_query("SELECT name FROM views WHERE standard='1' ORDER BY name");
		$objResult = mysql_fetch_object($query);
		return $objResult->name;
	}
	
	function setView($viaw) {
		$this->actualView = $viaw;
	}
	
	function getView() {
		return $this->actualView;
	}
	
	function getSelects() {
		$query = mysql_query("SELECT * FROM views ORDER BY name");
		$reta = "";
		while ($objResult = mysql_fetch_object($query)) {
			$selected = "";
			if($objResult->name==$this->actualView) { $selected =  ' selected'; }
			$reta = $reta."<option value='".$objResult->name."'".$selected.">".ucwords($objResult->name)."</option>";
		}
		
		return $reta;
	}
}
?>