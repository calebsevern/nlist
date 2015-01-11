$(function() {
	
	$(".tab").click(function() {
	
		if($(this).hasClass("logout"))
			window.location.replace("auth/logout.php");
			
		else {
			$(".tab").removeClass("selected");
			$(this).addClass("selected");
			
			$(".content-pane").load("pages/" + $(this).data("url"));
			
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