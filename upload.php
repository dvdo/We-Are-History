<?php

//ini_set('upload_max_filesize', '200M');
//phpinfo();

$link = mysql_connect("localhost", "history", "wearehistory");
if(!$link){
	die('Could not connect: ' .mysql_error());
}else{
	echo "connected!" ;
}
//Select databse
mysql_selectdb("upload_test");

if(!is_dir("uploads/")){ // check if directory exists
	mkdir("uploads/"); // make a new directory
	echo "directory created";
}


//function for saving data.
function savedata(){
//echo 'here';
	global $_FILES, $_POST, $putItAt;
	$sql = "INSERT INTO  `upload_test`.`files` (
`ID` ,
`Time` ,
`FileLocation` ,
`IP` ,
`Title`
)
VALUES (
NULL , UNIX_TIMESTAMP( ) ,  '".mysql_real_escape_string($putItAt)."',  '".$_SERVER['REMOTE_ADDR']."',  '".mysql_real_escape_string($_POST['title'])."'
)";

//echo 'here';
mysql_query($sql);
//mysql_query('INSERT INTO `movies` SET `title`="matrix reload", `url`="1647.flv"');
}

//see if file is uploaded
$putItAt = "uploads/".basename($_FILES['uploadedfile']['name']);
//echo $_FILES['uploadedfile']['name'];
//prevent .php from getting in and rename with .txt ..security risk for scripts
$putItAt = str_replace("php","txt",$putItAt);

//echo $_FILES['uploadedfile']['error'];
//echo "Stored in: " . "upload/" . $_FILES["file"]["name"];

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'],$putItAt)){
	//echo failure;
	//echo 'fail...';
	savedata();
	
	//echo 'fail...';
	//header("location: listfiles.php"); // redirect files to listfiles to listfiles
	
}else{
	if(copy($_FILES['uploadedfile']['tmp_name'],$putItAt)){
		//echo 'this time...';
		savedata();
		//header("location: listfiles.php");
		//echo $_FILES['uploadedfile']['error'];
		//mysql_error();
	}else{
		echo 'last Fail.';
	 }
	
  }



?>