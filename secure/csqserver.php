<?php 
/**
 * implementation of CSQ method
 * developed by minhaz@cistoner
 * WRONG CSQ detection not implemented
 */

if(!isset($checkVar))
{
    header("location: ../../index.php");
    exit;
}

/**
 * exceptions here
 */
class noCSQ extends Exception { };
class InvalidCSQ extends Exception { };


include 'ds.php';
$string = $_POST['csq'];

/**
 * these two array will be used to load up
 * sent collections to arrays
 */
$array = array();

/**
 * the CSQ can be diEntity or monoEntity based on 
 * no of entites passed
 */
$isDientityModel = false;

/**
 * array to store errors occuring in 
 * this process
 */
$errors = array();
/** push operation similar to stack **/
function push($str,$errors)
{
	$errors[count($errors)] = $str;
}

/**
 * regular expression to 
 * identify items in charecter
 */
$regex = "/{(.*?)}/i";

/**
 * finding all collections in CSQ
 * and loading it to array
 */
preg_match_all($regex, $string, $matches, PREG_OFFSET_CAPTURE);
$length = count($matches[1]);
if($length > 1)	$isDientityModel = true;

/**
 * two loops to load the collection items
 * to array $array!
 */
for($i = 0; $i<$length ;$i++)
{
	$array[$i] = array();
	$arr = explode(",",$matches[1][$i][0]);
	$len = count($arr);
	for($j = 0;$j<$len;$j++)
    {
        /**
         * this loads the collection item to array
         * if '~&' encounter it is replaced by ','
         */
        $array[$i][count($array[$i])] = str_replace("~&",",",$arr[$j]);
    }
	
	/**
	 * removes extra spaces after removing the {} data
	 */
	$string = preg_replace('~\s{1,}~', ' ',str_replace($matches[0][$i],"",$string));
}

/**
 * to remove the last space 
 */
while(substr($string,-1) == ' ')
{
	$string = substr($string, 0 ,count($string) - 2);
}

/**
 * =============parsing now=============== *
 */
$arr = explode(" ",$string);

/**
 * giving positions to data
 */
$action = $arr[0];		//TO-DO TASK
$entity1 = $arr[1];		//First Entity
$entity2 = "";			//Second Entity
$dir = "";				//Directional

if($isDientityModel)
{
	if(!isset($arr[3]))
	{
		throw new InvalidCSQ('The CSQ sent is INVALID!');
		exit;
	}
	
	$entity2 = $arr[3];		//Second Entity
	$dir = $arr[2];			//Directional
	/**
	 * directional would exist for sure for any diEntityModel 
	 * ex: ADD group {1,2} to group {1,2}
	 */
}

if($isDientityModel)
{
    /**
     * for 2-degree CSQ
     */

    /**
     * this will serve as index for array in file ds.php
     */
    $index = $action ."_" .$entity1 ."_" .$entity2;

    /**
     * checking access for this action
     */
    if(!isset($accessObj->accessLevel[$accessData[$index]]))
    {
        /**
         * case when user do not have access to perform this action
         * need to save this to log and return an error code
         */
        log::saveLog("[ajaxserver] PERMISSION BREACH ATTEMPT FOR:" .$index ." USER:" .$_SESSION['id']);
        echo '13';  //no permission error code
        exit;
    }

    /**
     * generating and executing mysql query
     */
    $sql = $sqlstruct[$index];
	for($j = 0; $j < count($array[1]);$j++)
	{
		for($i = 0; $i < count($array[0]);$i++)
		{
			$query =  str_replace("ielem", $array[0][$i],$sql);
			$query =  str_replace("jelem", $array[1][$j],$query);
			$query = mysql_query($query);
			if(!$query)push(mysql_error(),$errors);
		}
	}
}
else {
    /**
     * for 1-degree CSQ model
     */

    /**
     * this will serve as index for array in file ds.php
     */
    $index = $action ."_" .$entity1;

    /**
     * checking access for this action
     */
    if(!isset($accessObj->accessLevel[$accessData[$index]]))
    {
        /**
         * case when user do not have access to perform this action
         * need to save this to log and return an error code
         */
        log::saveLog("[ajaxserver] PERMISSION BREACH ATTEMPT FOR:" .$index ." USER:" .$_SESSION['id']);
        echo '13';  //no permission error code
        exit;
    }

    /**
     * generating and executing mysql query
     */
    $sql = $sqlstruct[$index];
	for($i = 0;$i<count($array[0]);$i++)
		{
			$query =  str_replace("ielem", $array[0][$i],$sql);
            $query = mysql_query($query);
			if(!$query)push(mysql_error(),$errors);
			
		}
}

/**
 * code to send the feedback from here after
 * generating it
 */
?>