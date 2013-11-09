<?php 
$time = time();
$prefix = array(
	"ADD" => "INSERT INTO ",
	"REMOVE" => "DELETE FROM ",
	"EDIT" => "UPDATE "
);
$tableName = array(
	"ADD_EMAIL_GROUP" => " group_subscriber ('user_id','group_id') VALUES ('ielem','jelem');",
	"ADD_EMAIL" => " `subscribers`(`email`, `date`) VALUES ('ielem','$time');",
	"REMOVE_EMAIL" => " `subscribers` WHERE id = 'ielem'; ",
	"REMOVE_EMAIL_GROUP" => " group_subscriber WHERE user_id = 'ielem' AND group_id = 'jelem';",
	"REMOVE_GROUP" => " `group` WHERE id = 'ielem';",
	"EDIT_EMAIL_EMAIL" => " `subscribers` SET email = 'jelem' WHERE id = 'ielem';"
);


$actionDetail = array(
	"ADD" => " Insert operation to database ",
	"REMOVE" => "Delete operation from database ",
	"EDIT" => " Update operation on database "
);
/**
 * bug: sometime we need to fix multiple tables for one operation 
 * like in cas of removing subscriber: we need to delete corresponding data from 
 * group_subscriber as well
 */

?>