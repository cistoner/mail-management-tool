<?php
/**
 * this library will handle all operations related to groups
 * dependency: db library
 */
if(!isset($checkVar)) 
{
	header("location: ../../index.php");
	exit;
}

class group
{

	/**
	 * 
	 * variable to hold data of certain subscribers which are
	 * in active display for the moment
	 * @var type multi-dimentional array
	 */
	public $grp = array();
	private $offset;		//offset for downloading data
	private $limit;		//limit of ids to be shown at a moment
	private $page;
	
	/**
	 * constructor for the subscribers class
	 */
	function __construct($l = 20,$p = 1)
	{
		$this->page = $p;
		$this->limit = $l;
		$this->offset = ($this->page - 1) * ($this->limit);
	}
	
	/**
	 * function to change value of limit and page
	 */
	 public function changeData($l = 10,$p = 1)
	 {
		$this->page = $p;
		$this->limit = $l;
		$this->offset = ($this->page - 1) * ($this->limit);
	 }
	 
	/**
	 * get data of groups to an array
	 * required for current context
	 */
	public function getGroups($key = false)
	{
		/**
		 * in case a search has been made 
		 * for a particular group name
		 */
		$prefix = "";
		if($key)
		{
			$prefix = "WHERE name LIKE %" .$key ."%";
		}
		
		$query = mysql_query("SELECT group.id,group.name,group.date,group.description,admin.username FROM `group` 
		INNER JOIN admin ON admin.id = group.admin_id " .$prefix ."
		LIMIT $this->limit OFFSET $this->offset");
		while($row = mysql_fetch_array($query))
		{
			$index = count($this->grp);
			$this->grp[$index] = array();
			$this->grp[$index]['id'] = $row['id'];
			$this->grp[$index]['name'] = $row['name'];
			$this->grp[$index]['date'] = date("D, dS F'y H:i:s",$row['date']);
			$this->grp[$index]['desc'] = $row['description'] ."<br><span class='label label-important'> &nbsp;Added by " .$row['username'] ."&nbsp; </span>";
			$subquery = mysql_query("SELECT count(*) FROM group_subscribers WHERE group_id = '" .$row['id'] ."'");
			$subrow = mysql_fetch_array($subquery);
			$this->grp[$index]['count'] = $subrow[0];
		}
		unset($row);
		unset($query);
		unset($subrow);
		unset($subquery);
	}
	
};
 