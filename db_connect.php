<?php 
    
    
	$conn = mysqli_connect('localhost', 'root', '', 'pawsitive');

	
	if(!$conn){
		echo 'Connection error: '. mysqli_connect_error();
	}

?>