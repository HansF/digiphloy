<?php

require_once "phing/Task.php";
class ZMySqlGetRecordTask extends Task {
	
	/**
	 * The message passed in the buildfile.
	 */
	private $recordid = null;
	private $hostname = null;
	private $db = null;
	private $sqluser = null;
	private $sqlpassword = null;
	
	/**
	 * The setter for the attribute "recordid"
	 */
	public function setrecordid($str) {
		$this->recordid = $str;
	}
	/**
	 * The setter for the attribute "recordid"
	 */
	public function sethostname($str) {
		$this->hostname = $str;
	}
	/**
	 * The setter for the attribute "recordid"
	 */
	public function setdb($str) {
		$this->db = $str;
	}
	/**
	 * The setter for the attribute "recordid"
	 */
	public function setsqluser($str) {
		$this->sqluser = $str;
	}
	/**
	 * The setter for the attribute "recordid"
	 */
	public function setsqlpassword($str) {
		$this->sqlpassword = $str;
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
		$sql = "SELECT * FROM tbldeploy INNER JOIN tblusers_repo on tbldeploy.repo_userID = tblusers_repo.repouserID WHERE tbldeploy.deployID = ".$this->recordid;
		$result = $mysqli->query ( $sql );
		$arr_row = $result->fetch_assoc ();
		foreach ( $arr_row as $key => $value ) {
			switch($key){
				case "repo_location":
					$value = $arr_row['repo_protocol'].$arr_row['repo_username'].":".$arr_row['repo_password']."@".$arr_row['repo_location'];
					break;
				default:
				break;
			}
		
			$this->project->setProperty ( "mysqlconfig.$key", $value );
		}
		
	}
}

?>
