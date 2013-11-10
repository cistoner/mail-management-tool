<?php 

echo "========================================" .newLine();
include 'ds.php';
function newLine(){return "<br>" .PHP_EOL;}
/**
 * test string
 */
$string = "ADD EMAIL {1,3,4,5} TO GROUP {2,3}";
echo "CSQ = " .$string .newLine();
/**
 * these two array will be used to load up
 * sent collections to arrays
 */
$array = array();

/**
 * regular expression to 
 * identify items in charecter
 */
$regex = "/{(.*?)}/i";

//finding first entity
preg_match_all($regex, $string, $matches, PREG_OFFSET_CAPTURE);
$length = count($matches[1]);
for($i = 0; $i<$length ;$i++)
{
	$array[$i] = array();
	$arr = explode(",",$matches[1][$i][0]);
	$len = count($arr);
	for($j = 0;$j<$len;$j++){$array[$i][count($array[$i])] = $arr[$j];}
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
$arr = explode(" ",$string);

/**
 * giving positions to data
 */
$isDientityModel = false;
$action = $arr[0];
$entity1 = $arr[1];
if(isset($arr[3]))
{
	$entity2 = $arr[3];
	$dir = $arr[2];
	$isDientityModel = true;
}
else if(isset($arr[2]))$entity2 = $arr[2];

//==============================================
echo "========================================" .newLine() ."OUTPUT" .newLine();
echo "[ ACTION ] " .$action ." - " .$actionDetail[$action] .newLine();
if($isDientityModel){
		echo "[ MODEL ] TWO ENTITY MODEL" .newLine();
		echo "[ ENTITY-1 ] " .$entity1 .newLine();
		echo "[ ENTITY-2 ] " .$entity2 .newLine();
		echo "[ DIRECTIONAL ] " .$dir .newLine();
}
else{
	echo "[ MODEL ] ONE ENTITY MODEL" .newLine();
	echo "[ ENTITY-1 ] " .$entity1 .newLine();	
}
echo "========================================" .newLine();
$sql = "";

echo newLine() ."SQL = " .newLine();
echo "========================================" .newLine();
if($isDientityModel)
{
	$sql .= $tableName[$action ."_" .$entity1 ."_" .$entity2];
	for($j = 0; $j < count($array[1]);$j++)
	{
		for($i = 0;$i<count($array[0]);$i++)
		{
			$out =  str_replace("ielem", $array[0][$i],$sql);
			$out =  str_replace("jelem", $array[1][$j],$out);
			echo $out .newLine();
		}
	}
}
else {
	$sql .= $tableName[$action ."_" .$entity1];
	for($i = 0;$i<count($arr1);$i++)
		{
			$out =  str_replace("ielem", $array[1][$i],$sql);
			echo $out .newLine();
		}
}

?>