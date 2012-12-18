<?php

require_once "phing/Task.php";
class ZMySqlCopyData extends Task {
	
	/**
	 * The message passed in the buildfile.
	 */
	private $recordid = null;
	private $hostname = null;
	private $db = null;
	private $sqluser = null;
	private $sqlpassword = null;
	private $fromfolder = null;
	private $tofolder = null;
	/**
	 * The setter for the attribute "recordid"
	 */
	public function setrecordid($str) {
		$this->recordid = $str;
	}
	/**
	 * The setter for the attribute "hostname"
	 */
	public function sethostname($str) {
		$this->hostname = $str;
	}
	/**
	 * The setter for the attribute "db"
	 */
	public function setdb($str) {
		$this->db = $str;
	}
	/**
	 * The setter for the attribute "sqluser"
	 */
	public function setsqluser($str) {
		$this->sqluser = $str;
	}
	/**
	 * The setter for the attribute "sqlpassword"
	 */
	public function setsqlpassword($str) {
		$this->sqlpassword = $str;
	}
	/**
	 * The setter for the attribute "fromfolder"
	 */
	public function setfromfolder($str) {
		$this->fromfolder = $str;
	}
	        /**
         * The setter for the attribute "tofolder"
         */
        public function settofolder($str) {
                $this->tofolder = $str;
        }

	
	
	/**
	 * The init method: Do init steps.
	 */
	public function init() {
		// nothing to do here
	}
	
	/**
	 * The main entry point method.
	 */
	public function main() {
		$mysqli = new mysqli ( $this->hostname, $this->sqluser, $this->sqlpassword, $this->db );
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		$sql = "SELECT * FROM tbldeploy INNER JOIN tbldata on tbldeploy.deployID = tbldata.deployID WHERE tbldeploy.deployID = " . $this->recordid;
		if ($result = $mysqli->query ( $sql )) {
			while ( $row = $result->fetch_assoc () ) {
				 if($this->copyFolder($this->fromfolder.$row['folder'],$this->tofolder.$row['folder'])){
					$this->log("Folder copied: ".$row['folder']);
				 }else{

				}
			}
		}
	}
	private function copyFolder($source="",$target="") {
		if ( is_dir( $source ) ) {
			@mkdir( $target );
			$d = dir( $source );
			while ( FALSE !== ( $entry = $d->read() ) ) {
				if ( $entry == '.' || $entry == '..' ) {
					continue;
				}
				$Entry = $source . '/' . $entry; 
				if ( is_dir( $Entry ) ) {
					$this->copyFolder( $Entry, $target . '/' . $entry );
					continue;
				}
				copy( $Entry, $target . '/' . $entry );
			}
			$d->close();
		}else {
			copy( $source, $target );
		}
		return true;
	}
}

?>

