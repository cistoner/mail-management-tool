<?php
/**
 * this library will handle all operations related to subscribers
 * dependency: db library
 */
if(!isset($checkVar)) 
{
	header("location: ../../index.php");
	exit;
}

class accounts
{
	/**
	 * this variable contain data about every email accounts 
	 * this will be populated by the constructor as soon as 
	 * the object will be created
	 */
	public $emails = array();
	
	/**
	 * constructor
	 * assuming database to be connected
	 */
	function __construct()
	{
		$this->getData();
	}
	
	/**
	 * function to retrieve data from Database
	 * Private: need not be called from outside
	 * this function is called automatically when object is created
	 * @param: none
	 */
	private function getData()
	{
		$index = 0;
		$query = mysql_query("SELECT *,admin.username FROM email_accounts 
		INNER JOIN admin ON admin.id = email_accounts.admin_id;");
		while($row = mysql_fetch_array($query))
		{
			$this->emails[$index] = array();
			$this->emails[$index]['id'] = $row['id'];
			$this->emails[$index]['email'] = $row['email'];
			$this->emails[$index]['date'] = date("D, dS F'y H:i:s",$row['date']);
			$this->emails[$index]['added_by'] = $row['username'];
			$this->emails[$index]['default'] = false;
			if($row['default'])$this->emails[$index]['default'] = true; 
			$index++;
		}
	}
};
 