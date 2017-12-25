<?php

include('is_logged.php');
if($_FILES["file"]["name"] != '')
{
 	$newFilename = time() . "_" . $_FILES["file"]["name"];
 	$location = 'upload/' . $newFilename;  
	move_uploaded_file($_FILES["file"]["tmp_name"], $location);
 	
 	mysqli_query($conn,"insert into photo (location) values ('$location')");
        
}
?>

