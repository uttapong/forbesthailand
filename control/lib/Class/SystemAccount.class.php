<?

	Class SystemAccount {
	
			public $FirstName;
			public $LastName;
			public $AccountID;
			public $Username;
			public $Password;
			public $Email;
			public $Address;
			public $PictureID;
			public $Picture;
			public $CreateDate;
			public $LastUpdate;
			public $LastLogin;
			public $Language;
			public $Gender;
			public $IP;
			public $GroupID;
			
			public $AccountType;
			
			public function checkPermissionAccess($PermissionLevel,$PermissionGroup = NULL,$Redirect=false) {
				
				return true; // GOLF EDIT
			
				$Return = NULL;
				$Priority = NULL;
			
				// Check Level
				if (($PermissionLevel == "everyone") || ($this->AccountType=="root") || ($this->AccountType == "master"))
					$Return = true;
				else if (($PermissionLevel == "admin") && ($PermissionLevel == $this->AccountType ))
					$Return = true;
				else if (($PermissionLevel == "user") && (($PermissionLevel == $this->AccountType ) || ($this->AccountType == "admin") ))
					$Return = true;
				else
					$Return = false;
					
				// Check In Group
				if ((!empty($PermissionGroup))  && ($PermissionLevel != "everyone")){
					
					if ( $this->getPermissionLevelPriority($PermissionLevel) <= $this->getPermissionLevelPriority($this->AccountType)  ) {
					
						if (!in_array($PermissionGroup,$this->GroupID))  {	$Return = false;	}
							
					}
					
				}
				
					
				if (!$Return && $Redirect)
					@header("Location:../");
				
				return $Return;
			
			}
			
			
			
			private function getPermissionLevelPriority($PermissionName) {
			
				if ($PermissionName == "root") 
					return 1 ;
				else if ($PermissionName == "master") 
					return 2 ;
				else if ($PermissionName == "user") 
					return 3 ;
				else if ($PermissionName == "everyone") 
					return 4 ;
					
			
			}
	
	}

?>