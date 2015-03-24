<?php
	
	require_once "Mail.php";
	
	$configs = include('../conf.php');
	$db_name = $configs['db'];
	$host = $configs['host'];
	
	$tomorrow = date('m/d/y',strtotime("+1 days"));
	//$tomorrow = "01/20/2015";
	
	$pdo = new PDO("mysql:host=$configs->host; dbname=$db_name; charset=utf8", $configs['username'], $configs['password']);	
	
	
	
	
	function send_email($participant, $experiment) {
		print_r($participant);
	}
	
	
	function lookup_experiment($experiment_id) {
		GLOBAL $pdo, $db_name;
		
		$stmt = $pdo->prepare("SELECT * FROM $db_name.Experiments WHERE id=\"$experiment_id\"");
		$stmt->execute($values_array);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if(count($rows) > 0)
			return $rows[0];
		return NULL;
	}
	
	
	function lookup_participant($participant_id) {

		GLOBAL $pdo, $db_name;
		
		$stmt = $pdo->prepare("SELECT * FROM $db_name.Participants WHERE id=\"$participant_id\"");
		$stmt->execute($values_array);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if(count($rows) > 0)
			return $rows[0];
		return NULL;
	}
	
	function write_email($experiment, $session, $participant) {
		
		GLOBAL $pdo, $db_name, $configs;
		
		$participant_name = $participant["full_name"];
		$from = $experiment["proctor_email"];
		$proctor = $experiment["proctor"];
		$exp_description = $experiment["description"];
		$proctor_email = $experiment["proctor_email"];
		$to = $participant["email"];
		$exp_name = $experiment["name"];
		$session_start = $session["start_time"];
		$session_end = $session["end_time"];
		$session_date = $session["start_date"];
		$session_lab = $session["laboratory"];
		$session_notes = $session["notes"];
		$p = explode("php", $configs['public_directory']);
		$register_url = $p[0] . "public/confirm.php?e=" . $experiment['id'];
			$register_url .= "&s=" . $session['id'];
			$register_url .= "&p=" . $participant['id'];
		
		$reg_statement = $pdo->prepare("SELECT * FROM $db_name.Email");
		$reg_statement->execute(array());
		$regs = $reg_statement->fetchAll(PDO::FETCH_ASSOC);
		
		if($regs[0] != NULL) {
			
			$email = $regs[0]["content"];
			$email = str_replace("[full_name]", $participant_name, $email);
			$email = str_replace("[experiment_name]", $exp_name, $email);
			$email = str_replace("[experiment_description]", $exp_description, $email);
			$email = str_replace("[start_date]", $session_date, $email);
			$email = str_replace("[start_time]", $session_start, $email);
			$email = str_replace("[end_time]", $session_end, $email);
			$email = str_replace("[lab]", $session_lab, $email);
			$email = str_replace("[notes]", $session_notes, $email);
			$email = str_replace("[confirmation_link]", $register_url, $email);
			$email = str_replace("[proctor_name]", $proctor, $email);
			$email = str_replace("[proctor_email]", $proctor_email, $email);
		}
		
		return $email;
	}
	
	
	$stmt = $pdo->prepare("SELECT * FROM $db_name.Sessions WHERE reminder IS NOT NULL AND reminder != 0");
	$stmt->execute($values_array);
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	$matches = array();
	
	
	for($i=0; $i<count($rows); $i++) {
		array_push($matches, $rows[$i]);

		
		/*
		*	Get hours between today and start date
		*/
		
		$date = strtotime($rows[$i]["start_date"] . " " . $rows[$i]["start_time"]);
		$today = strtotime("now");
		$reminder = $rows[$i]["reminder"];
		$hours = floor(($today - $date) / 3600);
		
		if($reminder == $hours) {
			
			$session_id = $rows[$i]["id"];
			$stmt = $pdo->prepare("SELECT * FROM $db_name.Registration WHERE associated_session=$session_id");
			$stmt->execute($values_array);
			$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			for($r=0; $r<count($registrations); $r++) {
			
					$participant = lookup_participant($registrations[$r]["associated_participant"]);
					if($participant["email"]) {
						$experiment = lookup_experiment($registrations[$r]["associated_experiment"]);
						$session = $rows[$i];
						
						$session_date = $session["start_date"];
						$exp_name = $experiment["name"];
						$session_start = $session["start_time"];
						$session_end = $session["end_time"];
						$from = $experiment["proctor_email"];
						$to = $participant["email"];
						$subject = "$exp_name Invitation: $session_start - $session_end on $session_date";
						$body = write_email($experiment, $session, $participant);
						
						$host = $configs['smtp_host'];
						$port = $configs['smtp_port'];
						$username = $configs['smtp_login'];
						$password = $configs['smtp_password'];
						
						$headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject, 'Content-Type' => "text/html; charset=ISO-8859-1");
						
						$smtp = Mail::factory('smtp', array ('host' => $host, 'port' => $port, 'auth' => true, 'username' => $username, 'password' => $password));
						$mail = $smtp->send($to, $headers, $body);
						if (PEAR::isError($mail)) { 
							error_log($mail->getMessage());
						} else {  
							$emails_sent++;
						}
										
				
					}
			}
		}
		
		$registrations = NULL;
	}
		
	exit();

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	