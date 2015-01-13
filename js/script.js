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
		$(".name-text").html(experiment.name);
		$(".experiment-name").val(experiment.name).trigger("keyup");
		$(".experiment-description").val(experiment.description).trigger("keyup");
		$(".experiment-class").val(experiment.class_name).trigger("keyup");
		$(".experiment-proctor").val(experiment.proctor).trigger("keyup");
		$(".experiment-proctor-email").val(experiment.proctor_email).trigger("keyup");
	});
	
	
	//Get sessions
	
	/*var query = new Query("Sessions");
	query.equalTo("associated_experiment", experiment_id);
	query.find(function(results) {
		console.log(results.length);	
	});*/
	
}

$(document).on('submit', '.save-experiment', function(e) {

	e.preventDefault();
	
	var query = new Query("Experiments");
	query.get("209126086", function(experiment) {
		console.log(experiment);
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
		console.log("Created Session with id: " + a.id);
		
		a.set("associated_experiment", window.active_experiment_id);
		a.save(function(result) {
			console.log("Experiment #" + result.id + " updated.");
		});
	});
	
	return false;
});























