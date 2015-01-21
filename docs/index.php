<?php

	//if they DID upload a file...
	if($_FILES['doc']['name'])
	{
		//if no errors...
		if(!$_FILES['doc']['error'])
		{
			//now is the time to modify the future file name and validate the file
			$new_file_name = strtolower($_FILES['doc']['tmp_name']); //rename file
			if($_FILES['doc']['size'] > (102400000)) //can't be larger than 1 MB
			{
				$message = 'Oops!  Your file\'s size is to large.';
			}
			
			//if the file has passed the test
			else {
				//move it to where we want it to be
				move_uploaded_file($_FILES['doc']['tmp_name'], dirname(__FILE___) . '/' . $new_file_name);
				$message = 'Congratulations!  Your file was accepted.';
			}
		}
		//if there is an error...
		else
		{
			//set that to be the returned message
			$message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['doc']['error'];
		}
	}

	//you get the following information for each file:
	$_FILES['doc']['name'];
	$_FILES['doc']['size'];
	$_FILES['doc']['type'];
	$_FILES['doc']['tmp_name'];
	
	echo "Message: " . $message;