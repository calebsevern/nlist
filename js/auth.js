
function validateForm() {
	
	if($("input[name='email']").val().trim() == "" ||
	   $("input[type='password']").val().trim() == "")
		return false;
	
	if($("input[type='submit']").attr("data-flag") == "register") {
		if($("input[type='full_name']").val() == "" ||
	       $("input[type='confirm_password']").val() == "")
			return false;
			
		if($("input[name='password'").val() != $("input[name='confirm_password']").val())
			return false;
	}
	
	return true;
}


function ajaxLogin(form_data) {
	$.ajax({
		type: "POST",
		url: "login.php",
		data: form_data,
		success: function(data) {
			if(data == "ok")
				window.location.replace("../");
		}
	});
}

function ajaxRegister(form_data) {
	$.ajax({
		type: "POST",
		url: "register.php",
		data: form_data,
		success: function(data) {
			if(data == "ok")
				ajaxLogin(form_data);
		}
	});
}


$(function() {
	$(document).on('click', '.login-link', function() {
		$("form").attr("action", "login.php");
		$(".register-box > h3").html("Sign In");
		$("input[type='submit']").val("Sign In");
		$("input[type='submit']").attr("data-flag", "login");
		$("input[name='full_name']").hide();
		$("input[name='confirm_password']").hide();
		$(".existing-account").html("Need an account? <a href='#' class='register-link'>Register</a>");
	});
	
	$(document).on('click', '.register-link', function() {
		$("form").attr("action", "register.php");
		$(".register-box > h3").html("Sign Up");
		$("input[type='submit']").val("Register");
		$("input[type='submit']").attr("data-flag", "register");
		$("input[name='full_name']").show();
		$("input[name='confirm_password']").show();
		$(".existing-account").html('Already have an account? <a href="#" class="login-link">Log In</a>');
	});
	
	$(".register-form").submit(function(e) {
		
		if(!validateForm()) {
			e.preventDefault();
			alert("Please check the form.");
		} else {
			if($(this).attr("action") == "register.php")
				ajaxRegister($(this).serialize());
			ajaxLogin($(this).serialize());
			return false;
		}
	});
});