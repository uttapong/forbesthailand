<?php
 Class QueryDatabase {  

		var $var_username;
		var $var_password;
		var $var_host;
		var $var_dbname;
		var $Conn;
		var $var_result;

       var $var_totalPage;  
	   var $var_totalRow;
	   var $var_rowCount ;
  
       function QueryDatabase($host,$user,$pwd,$dbName) {

			$this->var_username 	= $user;
			$this->var_password 	= $pwd;
			$this->var_host 			= $host;
			$this->var_dbname 		= $dbName;
			$this->_connect();
			$this->_setDatabaseCharset("utf8");
			
       } 
	   
	   	function  _connect() {
			$this->Conn = mysqli_connect($this->var_host,$this->var_username,$this->var_password);
			mysqli_select_db($this->Conn,$this->var_dbname);
		}
		
		function _execute($sql) {
			mysqli_query($this->Conn,$sql);
		}

	   	function _setDatabaseCharset($encoding) {
			$this->_execute("SET NAMES '".$encoding."'");
		}
   
   
   	 function execute($sql) {
			mysqli_query($this->Conn,$sql);
		}
   
       function query($sql,$page=0,$pageSize=0,$type_c=0)  
       {  
             
			 if ($page+$pageSize>0){
				 
				 	if ($page==0) $page=1;

					if ($type_c==0){
						$sql_c = "select count(*) CNT from (".$sql.") tb";
						$result=mysqli_query($this->Conn,$sql_c); 
						$rs=mysqli_fetch_array($result);
						$num=$rs['CNT'];
						
					}else{
						$result=mysqli_query($this->Conn,$sql);  
						 $num=mysqli_num_rows($result);  
						
					}
					
					$rt = $num%$pageSize;
					$this->var_totalRow = $num;
				 
					$this->var_totalPage = ($rt!=0) ? ceil($num/$pageSize) : floor($num/$pageSize);  
					$goto = ($page - 1) * $pageSize;  
					$sql .= " LIMIT $goto , ".$pageSize; 
					
				
				
			 }
             $result=mysqli_query($this->Conn,$sql);  
			$this->var_result = $result;
			
			
			if($page==0){
				$this->var_totalRow = mysqli_num_rows($result);
			}
			
			$this->var_rowCount = mysqli_num_rows($result);
	
             return $result;  
       }  
	   
	   	function getResult() {
	   		$RowNumber=0;
	   		$Rs=array();
			while ($Row = mysqli_fetch_array($this->var_result)) {
				$Rs[] = array_merge(array("ROWNUM" => $RowNumber++),(array)$Row);
			}
			
			return $Rs;
		}
		
		
	 function getRowCount() {
			return $this->var_rowCount;
		}
		
	 function getTotalRow() {
			return $this->var_totalRow;
		}
		
 	function getInsertID() {
		return mysql_insert_id();
	}

 } 
 ?>
