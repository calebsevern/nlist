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
	});
	
	
	//Get sessions
	
	var query = new Query("Sessions");
	query.equalTo("associated_experiment", experiment_id);
	query.find(function(results) {
		
		for(var i=0; i<results.length; i++) {
			$(".sessions-list").append('<div class="session">\
											<div class="session-date">' + results[i].start_date + '</div>\
											<div class="timeframe">\
												' + results[i].start_time + ' to ' + results[i].end_time + '\
											</div>\
											<div class="users">\
												<text class="num">' + results[i].required_participants + '</text>\
												<br><br><br>required\
											</div>\
											<div class="reserve">\
												<text class="num">' + results[i].reserve_participants + ' on reserve</text>\
											</div>\
										</div>');
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
		experiment.save(function(a) {
			window.location.reload();
		});
	});
	
	return false;
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
		
		a.set("start_date", c);
		a.set("start_time", $(".session-time").val().replace("am", "").replace("pm", ""));
		a.set("end_time", end_hours + ":" + end_minutes);
		a.set("length", hours + ":" + length_min);
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
	
		if(results) {
		
			console.log(results);
			for(var i=0; i<results.length; i++) {
				
				$(".experiments-list").append('<div class="experiment">\
												<div class="experiment-name" id="' + results[i].id + '">\
													' + results[i].name + '\
												</div>\
												<div class="description">\
													' + results[i].description + '\
												</div>\
												<div class="reg-url">\
													<i class="fa fa-share-square"></i> <a href="experiment.php?id=' + results[i].id + '">http://example.com/e/?e=3923758</a>\
												</div>\
											</div>');
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
	
		for(var i=0; i<results.length; i++) {
			
			$(".experiments-list").append('<div class="experiment">\
											<div class="experiment-name" id="' + results[i].id + '">\
												' + results[i].name + '\
											</div>\
											<div class="description">\
												' + results[i].description + '\
											</div>\
											<div class="reg-url">\
												<i class="fa fa-share-square"></i> <a href="experiment.php?id=' + results[i].id + '">http://example.com/e/?e=3923758</a>\
											</div>\
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
	
	var query = new Query("Participants");
	query.create(function(a) {
		console.log("Created Participants with id: " + a.id);
		
		a.set("email", $(".participant-email").val());
		a.set("username", $(".participant-email").val());
		a.set("full_name", $(".participant-name").val());
		a.set("phone_number", $(".participant-phone").val());
		a.set("notes", $(".participant-notes").val());
		a.save(function(result) {
			alert('Participant created.');
			window.location.reload();
		});
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
			$(".new-form").append(results[i].full_name + "<br><br>");
		}	
	});
}













