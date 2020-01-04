<?php
    class UserInfo{
		public $UserID;
		public $AccessLevel;
		public $Role;
		
		function __construct($_UserID, $_AccessLevel, $_Role)
		{
			$this->UserID = $_UserID;
			$this->AccessLevel = $_AccessLevel;
			$this->Role = $_Role;
		}
	}
?>