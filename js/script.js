$(function() {
	
	$(".tab").click(function() {
	
		if($(this).hasClass("logout"))
			window.location.replace("auth/logout.php");
			
		else {
			$(".tab").removeClass("selected");
			$(this).addClass("selected");
			
			$(".content-pane").attr("src", $(this).data("url"));
			
			if($(this).text())
				document.title = "nlist | " + $(this).text();
		}
	});
	
	
	$(document).on("keyup", "input[type='text']", function(e) {
		if($(this).val().trim() != "") {
			$("[data-for='" + $(this).attr("class") + "']").each(function() {
				$(this).css("display", "inline");
			});
		} else {
			$("[data-for='" + $(this).attr("class") + "']").each(function() {
				$(this).css("display", "none");
			});
		}
	});
	
	$(document).on("keyup", "textarea", function(e) {
		if($(this).val().trim() != "") {
			$("[data-for='" + $(this).attr("class") + "']").each(function() {
				$(this).css("display", "inline");
			});
		} else {
			$("[data-for='" + $(this).attr("class") + "']").each(function() {
				$(this).css("display", "none");
			});
		}
	});
	
	
});



/*
*	url: admin/newexperiment.php
*/

$(document).on('submit', '.create-new-experiment', function(e) {

	e.preventDefault();
	
	var query = new Query("Experiments");
	query.create(function(a) {
		console.log("Created Experiment with id: " + a.id);
		
		a.set("name", $(".experiment-name").val());
		a.set("description", $(".experiment-description").val());
		a.set("class_name", $(".experiment-class").val());
		a.set("proctor", $(".experiment-proctor").val());
		a.set("proctor_email", $(".experiment-proctor-email").val());
		a.save(function(result) {
			window.location.replace("experiment.php?id=" + result.id);
		});
	});
	
	return false;
});






/*
*	url: admin/experiment.php
*/

function populateExperimentDetails(experiment_id) {


	//Get experiment information
	
	var query = new Query("Experiments");
	query.equalTo("id", experiment_id);
	query.find(function(results) {
		experiment = results[0];
		window.active_experiment_id = experiment.id;
		$(".name-text").html(experiment.name);
		$(".experiment-name").val(experiment.name).trigger("keyup");
		$(".experiment-description").val(experiment.description).trigger("keyup");
		$(".experiment-class").val(experiment.class_name).trigger("keyup");
		$(".experiment-proctor").val(experiment.proctor).trigger("keyup");
		$(".experiment-proctor-email").val(experiment.proctor_email).trigger("keyup");
		if(experiment.finished == 1)
			$(".experiment-finished").prop("checked", true);
			
	});
	
	
	//Get sessions
	
	var query = new Query("Sessions");
	query.equalTo("associated_experiment", experiment_id);
	query.find(function(results) {
		
		for(var i=0; i<results.length; i++) {
			$(".sessions-list").append('<div class="session" id="' + results[i].id + '">\
											<div class="session-date">' + results[i].start_date + '</div>\
											<div class="lab-name">\
												' + results[i].laboratory + '\
											</div>\
											<div class="timeframe">\
												' + results[i].start_time + ' to ' + results[i].end_time + '\
											</div>\
											<div class="lab-notes">\
												' + results[i].notes + '\
											</div>\
											<div class="users">\
												<text class="num" style="font-size: 56px;">' + results[i].required_participants + '</text><br> required\
											</div>\
											<div class="reserve">\
												<text class="num">' + results[i].reserve_participants + '</text> on standby\
											</div>\
										</div>');
										
			$(".session").click(function() {
				window.location.replace("session.php?id=" + this.id + "&experiment=" + experiment_id);
			});
		}
	});
}

$(document).on('submit', '.save-experiment', function(e) {

	e.preventDefault();
	
	var query = new Query("Experiments");
	query.get(window.active_experiment_id, function(experiment) {
		experiment.set("name", $(".experiment-name").val());
		experiment.set("description", $(".experiment-description").val());
		experiment.set("class_name", $(".experiment-class").val());
		experiment.set("proctor_email", $(".experiment-proctor-email").val());
		experiment.set("proctor", $(".experiment-proctor").val());
		
		if($(".experiment-finished").is(":checked"))
			experiment.set("finished", 1);
		else
			experiment.set("finished", 0);
		
		experiment.save(function(a) {
			window.location.reload();
		});
	});
	
	return false;
});





/*
*	admin/session.php
*/

function editSessionDetails(session_id) {


	//Get Session information
	
	var query = new Query("Sessions");
	query.equalTo("id", session_id);
	query.find(function(results) {
		session = results[0];
		window.active_session_id = session.id;
		
		var session_date = new Date(session.start_date).toISOString(0, 10).substring(0, 10);
		var start_hour = session.start_time.split(":")[0];
		var start_min = session.start_time.split(":")[1];
		var session_time = (start_hour > 11) ? (parseFloat(start_hour) - 12) + ":" + start_min + "pm" : start_hour + ":" + start_min + "am";
		var duration_hours = (session.duration.split(":")[0] < 10) ? "0" + session.duration.split(":")[0] : session.duration.split(":")[0];
		var duration_minutes = session.duration.split(":")[1];
		
		$(".session-date").val(session_date);
		$(".session-time").val(session_time);
		$(".session-lab").val(session.laboratory).trigger("keyup");
		$(".required-participants").val(session.required_participants);
		$(".reserve-participants").val(session.reserve_participants);
		$(".session-notes").val(session.notes).trigger("keyup");
		$(".session-length").val(duration_hours + ":" + duration_minutes + ":00");
		
	});
}


function isRegistered(session_id, experiment_id, participant_id) {
	var query = new Query("Registration");
	query.equalTo("associated_session", session_id);
	query.equalTo("associated_experiment", experiment_id);
	query.equalTo("associated_participant", participant_id);
	query.find(function(results) {
		
		
		//Modify existing Registration or create a new one.
		
		if(results.length > 0) {
			if(results[0].active == 1) {
				
				$(".row-" + participant_id).css("color", "black");
				$("#" + participant_id).prop("checked", true);
				var status = (results[0].confirmed == 1) ? '<i class="fa fa-check" style="color: #2ecc71;"></i>' : '<i class="fa fa-exclamation-triangle" style="color: #F4D03F;"></i>';
				
				$(".conf-status-" + participant_id).html(status);
				
			} else if(results[0].standby == 1) {
				
				$(".row-" + participant_id).css("color", "black");
				$("input[data-pid='" + participant_id + "']").prop("checked", true);
				var status = (results[0].confirmed == 1) ? '<i class="fa fa-check" style="color: #2ecc71;"></i>' : '<i class="fa fa-exclamation-triangle" style="color: #F4D03F;"></i>';
				$(".conf-status-" + participant_id).html(status);
				
			}
		}
	});
}

function getSessionParticipants(session_id, experiment_id) {
	window.active_experiment_id = experiment_id;
	var query = new Query("Participants");
	query.find(function(results) {
		for(var i=0; i<results.length; i++) {
					
			$(".sessions-list").append('<tr class="participant row-' + results[i].id + '" style="color: rgba(0, 0, 0, .5);">\
											<td class="conf-status-' + results[i].id + '" style="text-align: center;"></td>\
											<td><input type="checkbox"  class="add-checkbox" id="' + results[i].id + '"></td>\
											<td><input type="checkbox" class="reserve-checkbox" data-pid="' + results[i].id + '"></td>\
											<td>' +  results[i].full_name + '</td>\
											<td>' +  results[i].email + '</td>\
											<td>' +  results[i].tag + '</td>\
										</tr>');
									
			isRegistered(session_id, experiment_id, results[i].id);
		}
	});
}


$(document).on('click', '.select-all', function() {

	if($(this).is(":checked"))
		$("input[type='checkbox']").each(function() {
			if(!$(this).hasClass("select-all") && !$(this).hasClass("reserve-checkbox") && $(this).is(":visible"))
				$(this).prop("checked", true).trigger("click").trigger("click");
		});
	else {
		$("input[type='checkbox']").each(function() {
			if(!$(this).hasClass("select-all") && !$(this).hasClass("reserve-checkbox") && $(this).is(":visible"))
				$(this).prop("checked", false).trigger("click").trigger("click");
		});
	}
});


function checkRegistration(participant_id, is_active) {
	
	if(participant_id) {
		var is_standby = ($("input[data-pid='" + participant_id + "']").is(":checked")) ? 1 : 0;
		
		var query = new Query("Registration");
		query.equalTo("associated_experiment", window.active_experiment_id);
		query.equalTo("associated_session", window.active_session_id);
		query.equalTo("associated_participant", participant_id);
		query.find(function(results) {
			
			
			//Modify existing Registration or create a new one.
			
			if(results.length > 0) {
			
				var q = new Query("Registration");
				q.get(results[0].id, function(r) {
					
					r.set("active", is_active);
					r.set("standby", is_standby);
					r.save(function(r) {
					
					});
				});
				
				
			
				
			} else if(is_active === 1 || is_standby === 1) {
				var query = new Query("Registration");
				query.create(function(a) {
					a.set("active", is_active);
					a.set("standby", is_standby);
					a.set("associated_experiment", window.active_experiment_id);
					a.set("associated_session", window.active_session_id);
					a.set("associated_participant", participant_id);
					a.save(function(result) {
						
					});
				});
			}
		});
	
	}
	
}


$(document).on('click', '.reserve-checkbox', function() {
	if($(this).is(":checked"))
		$("#" + $(this).attr('data-pid')).prop("checked", false);
});

$(document).on('click', '.add-checkbox', function() {
	if($(this).is(":checked"))
		$("input[data-pid='" + this.id + "']").prop("checked", false);
});

$(document).on('click', '.save-session-participants', function() {

	$("input[type='checkbox']").each(function() {
		if(!$(this).hasClass("select-all")) {
			if($(this).is(":checked"))
				checkRegistration(this.id, 1);
			else
				checkRegistration(this.id, 0);
		}
	});
});


$(document).on('click', '.send-session-emails', function() {

	var session_id = this.id;
	$(".email-status").show();
	$(".email-status > i").replaceWith('<i class="fa fa-spinner fa-spin"></i>');
	$(".email-status-text").html("Sending");
	
	$.post( "../php/send_session_emails.php", {session_id: session_id}).done(function(data) {
		$(".email-status > i").replaceWith('<i class="fa fa-check"></i>');
		$(".email-status-text").html(data);
		
	});
});


$(document).on('submit', '.edit-session', function(e) {

	e.preventDefault();
	
	var query = new Query("Sessions");
	query.get(window.active_session_id, function(a) {
		
		var hours = parseFloat(($(".session-length").val().split(":")[0]));
		var minutes = parseFloat(($(".session-length").val().split(":")[1]));
		var duration = (hours * 60) + minutes;
		
		var start_hours = parseFloat(($(".session-time").val().split(":")[0]));
		var start_minutes = parseFloat(($(".session-time").val().split(":")[1]));
		
		var start_total = (start_hours * 60) + start_minutes;
		var end_total = start_total + duration;
		
		var end_hours = Math.floor(end_total / 60);
		var end_minutes = (end_total % 60);
		if(end_minutes < 10)
			end_minutes = "0" + end_minutes;
		
		var length_min = (minutes < 10) ? "0" + minutes : minutes;
		//American-ize the date
		
		var b = new Date($(".session-date").val()).toISOString(0, 10).substring(0, 10);
		var c = b.split("-")[1] + "/" + b.split("-")[2] + "/" + b.split("-")[0];
		
		var pm = $(".session-time").val().indexOf("pm") > -1;
		var sh = (pm) ? parseFloat($(".session-time").val().split(":")[0]) + 12 : $(".session-time").val().split(":")[0];
		var sm = $(".session-time").val().replace("am", "").replace("pm", "").split(":")[1];
			
		end_hours = (pm) ? end_hours + 12 : end_hours;
		
		a.set("start_date", c);
		a.set("start_time", sh + ":" + sm);
		a.set("end_time", end_hours + ":" + end_minutes);
		a.set("duration", hours + ":" + length_min);
		a.set("associated_experiment", window.active_experiment_id);
		a.set("required_participants", $(".required-participants").val());
		a.set("reserve_participants", $(".reserve-participants").val());
		a.set("notes", $(".session-notes").val());
		a.set("laboratory", $(".session-lab").val());
	
		a.save(function(result) {
			window.location.reload();
		});
	});
		
	
	return false;
});


$(document).on('keyup', '.participant-search', function() {
	
	var query = $(this).val().toLowerCase();
	$(".participant").each(function() {
		var field = $(this).text().toLowerCase();
		if(field.indexOf(query) > -1)
			$(this).show();
		else
			$(this).hide();
	});
	
});





/*
*	admin/new_session.php
*/

function newSessionDetails(experiment_id) {


	//Get experiment information
	
	var query = new Query("Experiments");
	query.equalTo("id", experiment_id);
	query.find(function(results) {
		experiment = results[0];
		window.active_experiment_id = experiment.id;
		$(".name-text").html(experiment.name);
		$(".experiment-name").val(experiment.name).trigger("keyup");
		$(".experiment-description").val(experiment.description).trigger("keyup");
		$(".experiment-class").val(experiment.class_name).trigger("keyup");
		$(".experiment-proctor").val(experiment.proctor).trigger("keyup");
		$(".experiment-proctor-email").val(experiment.proctor_email).trigger("keyup");
	});
	
}

$(document).on('submit', '.new-session', function(e) {

	e.preventDefault();
	
	var query = new Query("Sessions");
	query.create(function(a) {
		
		
		//Get experiment duration 
		
		var hours = parseFloat(($(".session-length").val().split(":")[0]));
		var minutes = parseFloat(($(".session-length").val().split(":")[1]));
		var duration = (hours * 60) + minutes;
		
		var start_hours = parseFloat(($(".session-time").val().split(":")[0]));
		var start_minutes = parseFloat(($(".session-time").val().split(":")[1]));
		
		var start_total = (start_hours * 60) + start_minutes;
		var end_total = start_total + duration;
		
		var end_hours = Math.floor(end_total / 60);
		var end_minutes = (end_total % 60);
		if(end_minutes < 10)
			end_minutes = "0" + end_minutes;
		
		var length_min = (minutes < 10) ? "0" + minutes : minutes;
		//American-ize the date
		
		var b = new Date($(".session-date").val()).toISOString(0, 10).substring(0, 10);
		var c = b.split("-")[1] + "/" + b.split("-")[2] + "/" + b.split("-")[0];
		
		var pm = $(".session-time").val().indexOf("pm") > -1;
		var sh = (pm) ? parseFloat($(".session-time").val().split(":")[0]) + 12 : $(".session-time").val().split(":")[0];
		var sm = $(".session-time").val().replace("am", "").replace("pm", "").split(":")[1];
			
		end_hours = (pm) ? end_hours + 12 : end_hours;
		
		a.set("start_date", c);
		a.set("start_time", sh + ":" + sm);
		a.set("end_time", end_hours + ":" + end_minutes);
		a.set("duration", hours + ":" + length_min);
		a.set("associated_experiment", window.active_experiment_id);
		a.set("required_participants", $(".required-participants").val());
		a.set("reserve_participants", $(".reserve-participants").val());
		a.set("notes", $(".session-notes").val());
		a.set("laboratory", $(".session-lab").val());
		
		
		a.save(function(result) {
			window.location.replace("experiment.php?id=" + window.active_experiment_id);
		});
	});
	
	return false;
});








/*
*	admin/current_experiments.php
*/

function getCurrentExperiments() {

	var query = new Query("Experiments");
	query.equalTo("finished", 0);
	query.find(function(results) {
	
		if(results.length > 0) {
		
			for(var i=0; i<results.length; i++) {
				
				$(".experiments-list").append('<div class="experiment">\
												<div class="experiment-name" id="' + results[i].id + '">\
													' + results[i].name + '\
												</div>\
												<div class="description">\
													' + results[i].description + '\
												</div>\
											</div>');
											/*
												<div class="reg-url">\
													<i class="fa fa-share-square"></i> <a href="experiment.php?id=' + results[i].id + '">http://example.com/e/?e=3923758</a>\
												</div>\
											*/
			}	
		} else {
			$(".experiments-list").append('<div class="experiment no-experiments">\
												<br><br><br><br><br><i class="fa fa-plus"></i>\
												<br><br><br>No active experiments! Why not create one?\
											</div>');
		}

		$(".experiment-name").click(function() {
			window.location.replace("experiment.php?id=" + this.id);
		});
		
		$(".no-experiments").click(function() {
			window.location.replace("new_experiment.php");
		});
	});
}






/*
*	admin/completed_experiments.php
*/

function getCompletedExperiments() {

	var query = new Query("Experiments");
	query.equalTo("finished", 1);
	query.find(function(results) {
		
		if(results.length > 0) {
			for(var i=0; i<results.length; i++) {
				
				$(".experiments-list").append('<div class="experiment">\
												<div class="experiment-name" id="' + results[i].id + '" style="background: rgba(0, 0, 0, .12);">\
													' + results[i].name + '\
												</div>\
												<div class="description">\
													' + results[i].description + '\
												</div>\
											</div>');
			}
		} else {
			
			$(".experiments-list").append('<div class="experiment no-experiments">\
												<br><br><br><br><br><i class="fa fa-plus"></i>\
												<br><br><br>No completed experiments. You should make one.\
											</div>');
		}

		$(".experiment-name").click(function() {
			window.location.replace("experiment.php?id=" + this.id);
		});
	});
}



/*
*	admin/all_experiments.php
*/

/*
*	admin/completed_experiments.php
*/

function getAllExperiments() {

	var query = new Query("Experiments");
	query.find(function(results) {
		
		if(results.length > 0) {
			for(var i=0; i<results.length; i++) {
				
				if(results[i].finished == 0) {
					$(".experiments-list").append('<div class="experiment">\
													<div class="experiment-name" id="' + results[i].id + '">\
														' + results[i].name + '\
													</div>\
													<div class="description">\
														' + results[i].description + '\
													</div>\
												</div>');
				} else {
					$(".experiments-list").append('<div class="experiment">\
													<div class="experiment-name" id="' + results[i].id + '" style="background: rgba(0, 0, 0, .12);">\
														' + results[i].name + '\
													</div>\
													<div class="description">\
														' + results[i].description + '\
													</div>\
												</div>');
				}
			}
		} else {
			
			$(".experiments-list").append('<div class="experiment no-experiments">\
												<br><br><br><br><br><i class="fa fa-plus"></i>\
												<br><br><br>No completed experiments. You should make one.\
											</div>');
		}

		$(".experiment-name").click(function() {
			window.location.replace("experiment.php?id=" + this.id);
		});
	});
}





/*
*	admin/participant_attributes.php
*/

$(document).on('blur', '.new-attr-name', function() {

	if($(this).val()) {
		
		var query = new Query("Participant_Attributes");
		query.create(function(a) {
			console.log(a);
			a.set("name", "TEST");
			a.save(function(result) {
				alert("saved");
			});
		});
	}
});




/*
*	admin/new_participant.php
*/

$(document).on('submit', '.create-new-participant', function(e) {

	e.preventDefault();
	
	var q = new Query("Participants");
	q.equalTo("email", $(".participant-email").val());
	q.find(function(r) {
		console.log(r);
		if(r.length < 1) {
			var query = new Query("Participants");
			query.create(function(a) {
				
				a.set("email", $(".participant-email").val());
				a.set("full_name", $(".participant-name").val());
				a.set("phone_number", $(".participant-phone").val());
				a.set("notes", $(".participant-notes").val());
				a.set("tag", $(".participant-tag").val());
				a.save(function(result) {
					alert('Participant created.');
					window.location.reload();
				});
			});
		} else {
			alert("Participant with email " + $('.participant-email').val() + " already exists.");
		}
	});
	
	
	
	return false;
});




/*
*	admin/participant_overview.php
*/

function getAllParticipants() {

	var query = new Query("Participants");
	query.equalTo("password", "");
	query.find(function(results) {
	
		for(var i=0; i<results.length; i++) {
			$(".new-form tbody").append('<tr class="edit-participant" id="' + results[i].id + '">\
										<td>' + results[i].id + '</td>\
										<td>' + results[i].full_name + '</td>\
										<td>' + results[i].email + '</td>\
										<td>' + results[i].tag + '</td>\
										<td style="color: rgba(0, 0, 0, .6);">' + results[i].notes + '</td>\
								  ');
								
			$(".edit-participant").click(function() {
				window.location.replace("participant.php?id=" + this.id);
			});
		}	
	});
}


$(document).on('keyup', '.all-participant-search', function() {
	
	var query = $(this).val().toLowerCase();
	$(".all-participants tbody tr").each(function() {
		var field = $(this).text().toLowerCase();
		if(field.indexOf(query) > -1)
			$(this).show();
		else
			$(this).hide();
	});
	
});


$(document).on('click', '.import-action', function() {
	$(".import-status").show();
});


function readFile(file, onLoadCallback){
    var reader = new FileReader();
    reader.onload = onLoadCallback;
    reader.readAsText(file);
}


function createParticipant(email, full_name, phone_number, tag) {
	var q = new Query("Participants");
	q.equalTo("email", email);
	q.find(function(r) {
		if(r.length < 1) {
			var query = new Query("Participants");
			query.create(function(a) {
				
				a.set("email", email);
				a.set("full_name", full_name);
				a.set("phone_number", phone_number);
				a.set("tag", tag);
				a.set("notes", "");
				a.save(function(result) {
					$(".new-form tbody").prepend('<tr>\
												<td>' + result.id + '</td>\
												<td>' + result.full_name + '</td>\
												<td>' + result.email + '</td>\
												<td>' + result.tag + '</td>\
												<td style="color: rgba(0, 0, 0, .6);">' + result.notes + '</td>\
										  ');
				});
			});
		}
	});
}

//Parses through bulk user uploads...

$(document).on('change', '.participant-import', function(e) {
	readFile(this.files[0], function(e) {
	
		var text = e.target.result;
		var users = text.split("\n");
		
		for(var i=1; i<users.length; i++) {
			
			//TODO: Add non-definite formats
			
			var user = users[i].split(",");
			var email = user[0];
			var full_name = user[1];
			var phone_number = user[2];
			var tag = user[3];
			
			//Check to see if a user exists, and create on accordingly
			createParticipant(email, full_name, phone_number, tag);
			
		}		
	});
});




/*
*	url: admin/participant.php
*/

function getParticipantInfo(party_id) {

	var query = new Query("Participants");
	query.equalTo("id", party_id);
	query.find(function(results) {
	
		if(results.length > 0) {
		
			var party = results[0];
			$(".header-text").html("Edit " + party.full_name);
			$(".participant-name").val(party.full_name);
			$(".participant-email").val(party.email);
			$(".participant-phone").val(party.phone_number);
			$(".participant-tag").val(party.tag);
			$(".participant-notes").val(party.notes);
			
		}
		
	});
	
	$(document).on('submit', '.save-participant', function(e) {

		e.preventDefault();
		
		var q = new Query("Participants");
		q.get(party_id, function(a) {
			a.set("email", $(".participant-email").val());
			a.set("full_name", $(".participant-name").val());
			a.set("phone_number", $(".participant-phone").val());
			a.set("notes", $(".participant-notes").val());
			a.set("tag", $(".participant-tag").val());
			a.save(function(result) {
				window.location.reload();
			});
		});
		
		return false;
	});
}











/*
*	url: public/confirm.php
*/

function confirmRegistration(session_id, experiment_id, participant_id) {

	//This is ugly, I need to fix the JS wrapper...

	var q = new Query("Registration");
	q.equalTo("associated_session", session_id);
	q.equalTo("associated_experiment", experiment_id);
	q.equalTo("associated_participant", participant_id);
	q.find(function(r) {
		if(r.length > 0) {
			
			var query = new Query("Registration");
			query.get(r[0].id, function(a) {
				
				a.set("confirmed", "1");
				a.save(function(result) {
				});
			});
		}
	});
}


















