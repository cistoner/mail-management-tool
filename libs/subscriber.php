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

class subscribers
{

	/**
	 * 
	 * variable to hold data of certain subscribers which are
	 * in active display for the moment
	 * @var type multi-dimentional array
	 */
	public $subs = array();
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
	 
	public function getSubscribers($key = false)
	{
		/**
		 * in case a search has been made 
		 * for a particular email id
		 */
		$prefix = "";
		if($key)
		{
			$prefix = "WHERE email LIKE %" .$key ."%";
		}
		
		$query = mysql_query("SELECT * FROM subscribers " .$prefix ."LIMIT $this->limit OFFSET $this->offset");
		while($row = mysql_fetch_array($query))
		{
			$index = count($this->subs);
			$this->subs[$index] = array();
			$this->subs[$index]['id'] = $row['id'];
			$this->subs[$index]['email'] = $row['email'];
			$this->subs[$index]['date'] = date("D, dS F'y H:i:s",$row['date']);
			$this->subs[$index]['group'] = array();
			$subquery = mysql_query("SELECT `id`, `name` FROM `group` 
			INNER JOIN group_subscribers ON group_subscribers.group_id = group.id  
			WHERE group_subscribers.subscriber_id = " .$row['id'] .";");
			while($subrow = mysql_fetch_array($subquery))
			{
				$subindex = count($this->subs[$index]['group']);
				$this->subs[$index]['group'][$subindex] = array();
				$this->subs[$index]['group'][$subindex]['id'] = $subrow['id'];
				$this->subs[$index]['group'][$subindex]['gp_name'] = $subrow['name'];
			}
		}
		unset($subquery);
		unset($subrow);
		unset($row);
		unset($query);
	}
	
	/**
	 * function to return total no of subscribers
	 * return type: int
	 */
	public static function getSubscribersCount()
	{
		$query = mysql_query("SELECT count(*) FROM subscribers;");
		$row = mysql_fetch_array($query);
		return ($row[0]);
	}
	
	/**
	 * function to get latest subscribers from db
	 * default =  10 subscribers
	 * return type: array of string
	 */
	 public static function getLatestSubscribers($no = 10)
	 {
		$query = mysql_query("SELECT email,date FROM subscribers ORDER BY date DESC LIMIT $no;");
		$arr = array();
		while($row = mysql_fetch_array($query))
		{
			$index = count($arr);
			$arr[$index] = array();
			$arr[$index]['email'] = $row['email'];
			$arr[$index]['date'] = date("dS F'y",$row['date']);
		}
		return $arr;
	 }
};
 