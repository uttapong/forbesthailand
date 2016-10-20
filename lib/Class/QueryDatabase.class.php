<?

	Class QueryDatabase {
	
		private $Username;
		private $Password;
		private $Host;
		private $DatabaseName;
		private $Conn;
		private $Result; // ARRAY
		private $RowCount;
		
	
		public function QueryDatabase($host,$user,$pwd,$dbName) {
			$this->Username = $user;
			$this->Password = $pwd;
			$this->Host = $host;
			$this->DatabaseName = $dbName;
			$this->connect();
			// Default
			$this->setDatabaseCharset("utf8");
		}
		
		public function  connect() {
		
			$this->Conn = mysql_connect($this->Host,$this->Username,$this->Password);
			mysql_select_db($this->DatabaseName);
		}
		
		public function  disconnect() {
			mysql_close($this->Conn);
		}
		
		public function  getConnection() {
			return $this->Conn;
		}
		
		public function setDatabaseCharset($encoding) {
			$this->execute("SET NAMES '".$encoding."'");
		}
		
		public function execute($sql) {
			mysql_query($sql);
		}
		
		public function  query($sql,$Page='',$PageSize='') {
			
			$RowNumber = 1;
			$RESULT = NULL;
			
			if (trim($Page.$PageSize) != '') {
				$Page--;
				$startRec = $Page*$PageSize;
				$sql .= " LIMIT ".$startRec.",".$PageSize;
				$RowNumber = $startRec+1;
			}
	
			$ResultSet = mysql_query($sql);
	
			if (mysql_num_rows($ResultSet) >0){
				
				while ($Row = mysql_fetch_array($ResultSet)) {
			
				foreach ($Row as &$value) { $value = htmlspecialchars($value); }
				$RESULT[] = array_merge(array("ROWNUM" => $RowNumber++),(array)$Row);
			}
			}
			

			
			$this->Result = $RESULT;
			$this->RowCount = mysql_num_rows($ResultSet);
		}
		
		
		public function getResult() {
			return $this->Result;
		}
		
		
		public function getRowCount() {
			return $this->RowCount;
		}
		
		public function getInsertID() {
			return mysql_insert_id();
		}
		
		public function getError() {
			return mysql_error();
		}
		
		public function getTrueString($str) {
			return $str;
		}
	}

?>