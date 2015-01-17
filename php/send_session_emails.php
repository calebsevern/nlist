 <?php
	
	require_once "Mail.php";
	
	$configs = include('../conf.php');
	$db_name = $configs['db'];
	$host = $configs['host'];
	
	$session_id = $_POST['session_id'];
	$pdo = new PDO("mysql:host=$configs->host; dbname=$db_name; charset=utf8", $configs['username'], $configs['password']);	
	
	
	/*
	*	1. Get Session information
	*/
	
	$reg_statement = $pdo->prepare("SELECT * FROM $db_name.Sessions WHERE id=$session_id");
	$reg_statement->execute(array());
	$regs = $reg_statement->fetchAll(PDO::FETCH_ASSOC);
	
	if(count($regs) > 0) {
	
		$session_date   = $regs[0]['start_date'];
		$session_start  = $regs[0]['start_time'];
		$session_end    = $regs[0]['end_time'];
		$session_length = $regs[0]['duration'];
		$session_notes  = $regs[0]['notes'];
		$session_lab    = $regs[0]['laboratory'];
		$exp_id		    = $regs[0]['associated_experiment'];
		
	} else {
	
		echo "Session does not exist.";
		exit();
		
	}
		
		
		
	/*
	*	2. Get Experiment information	
	*/
	
	$reg_statement = $pdo->prepare("SELECT * FROM $db_name.Experiments WHERE id=$exp_id");
	$reg_statement->execute(array());
	$exps = $reg_statement->fetchAll(PDO::FETCH_ASSOC);
	
	if(count($exps) > 0) {
	
		$exp_name 		 = $exps[0]['name'];
		$exp_description = $exps[0]['description'];
		$proctor_email   = $exps[0]['proctor_email'];
		$proctor         = $exps[0]['proctor'];
		
	} else {
	
		echo "Experiment does not exist.";
		exit();
		
	}
	
	
	
	/*
	*	3a. Get Participant information
	*	3b. Send emails
	*/	
	
	$emails_sent = 0;
	
	$reg_statement = $pdo->prepare("SELECT * FROM $db_name.Registration WHERE associated_session=$session_id AND (active=TRUE OR standby=TRUE)");
	$reg_statement->execute(array());
	$regs = $reg_statement->fetchAll(PDO::FETCH_ASSOC);
	
	for($i=0; $i<count($regs); $i++) {
		
		/*
		*	3a
		*/
		$participant_id = $regs[$i]['associated_participant'];
		$reg_statement = $pdo->prepare("SELECT * FROM $db_name.Participants WHERE id=$participant_id");
		$reg_statement->execute(array());
		$parts = $reg_statement->fetchAll(PDO::FETCH_ASSOC);
		
		if(count($parts) > 0) {
			
			$participant_name  = $parts[0]['full_name'];
			$participant_email = $parts[0]['email'];
			$participant_id = $parts[0]['id'];
			$p = explode("php", $configs['public_directory']);
			$mail_link = $p[0] . "public/confirm.php?e=$exp_id&s=$session_id&p=$participant_id";
			
			/*
			*	3b
			*/
			
			$from = "nlist <$proctor_email>";
			$to = "$participant_name <$participant_email>"; 
			$subject = "$exp_name Invitation: $session_start - $session_end on $session_date";
			$body = "
			Details:
						
			Experiment Name: $exp_name
			Description: $exp_description
						
			Date: $session_date
			Starts: $session_start
			Ends: $session_end
			Location: $session_lab
			Notes: $session_notes
						
			Proctor: $proctor
			Contact address: $proctor_email	

			Confirm: $mail_link
					";
			
			$host = $configs['smtp_host'];
			$port = $configs['smtp_port'];
			$username = $configs['smtp_login'];
			$password = $configs['smtp_password']; 
			$headers = array ('From' => $from,   'To' => $to,   'Subject' => $subject);
			
			$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
			$mail = $smtp->send($to, $headers, $body);
			if (PEAR::isError($mail)) { 
				error_log($mail->getMessage());
			} else {  
				$emails_sent++;
			}		
		}	
	}
	
	echo $emails_sent . " email(s) sent.";
	
	exit();

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	