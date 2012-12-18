<?php

require_once "phing/Task.php";
class ZMySqlCopyFiles extends Task {
	
	/**
	 * The message passed in the buildfile.
	 */
	private $recordid = null;
	private $hostname = null;
	private $db = null;
	private $sqluser = null;
	private $sqlpassword = null;
	private $rootfolder = null;
	
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
	 * The setter for the attribute "rootfolder"
	 */
	public function setrootfolder($str) {
		$this->rootfolder = $str;
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
		$sql = "SELECT * FROM tbldeploy INNER JOIN tblfiles on tbldeploy.deployID = tblfiles.deployID WHERE tbldeploy.deployID = " . $this->recordid;
		if ($result = $mysqli->query ( $sql )) {
			/* fetch associative array */
			while ( $row = $result->fetch_assoc () ) {
				 if($this->writeToFile($row['file_path'],$row['file_name'],$row['data'])){
					 $this->log("File created: ".$row['file_name']);
				}else{
					throw new BuildException("Error while creating file:". $row['file_name']);
				}
			}
		}
	}
	private function writeToFile($path="",$filename = "", $content = "") {
		$path = $this->rootfolder.$path;

		if(!is_dir($path)){
			mkdir( $path, 0777, true );
                }
		
		$filename = $path."/".$filename;
		
		if (! $handle = fopen ( $filename, 'w' )) {
			echo "Cannot open file ($filename)";
			return false;
		}
		
		// Write $somecontent to our opened file.
		if (fwrite ( $handle, $content ) === FALSE) {
			echo "Cannot write to file ($filename)";
			return false;
		}
		
		
		fclose ( $handle );
		return true;
	}
}

?>

