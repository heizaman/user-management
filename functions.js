function ajaxRequest(api, jsonData) {
	$.ajax({
		type: "POST",
		data: JSON.stringify(jsonData),
		url: 'http://localhost/signinapp/backend/' + api,
		success: function(response) {
			//response = JSON.parse(response);	// may or may not be required
			//return response;
		},
		error: function(xhr, status, err) {
			console.log(err.toString());
		}
	});
}


function submitLoginForm() {
	var username = $("#username").val();
	var password = $("#password").val();

	$.ajax({
		type: "POST",
		data: JSON.stringify({"username": username, "password": password}),
		url: 'http://localhost/signinapp/backend/' + 'login.php',
		success: function(response) {
			if(response.status == 'failed') {
				alert("Error");
			}
			else {
				document.cookie = "token=" + response.data.token + "; path=/";
				window.location = "./welcome.html";
			}
		},
		error: function(xhr, status, err) {
			console.log(err.toString());
		}
	});
}


function submitRegisterForm() {
	var name = $("#name").val();
	var username = $("#username").val();
	var password = $("#password").val();

	$.ajax({
		type: "POST",
		data: JSON.stringify({"name": name, "username": username, "password": password}),
		url: 'http://localhost/signinapp/backend/' + 'registeruser.php',
		success: function(response) {
			if(response.status == 'failed') {
				alert("Error");
			}
			else {
				window.location = "./";
			}
		},
		error: function(xhr, status, err) {
			console.log(err.toString());
		}
	});
}


function getUserDetails() {
	var token = getCookie("token");

	if(token == "")
		window.location = "./index.html";

	$.ajax({
		type: "POST",
		data: JSON.stringify({"token": token}),
		url: 'http://localhost/signinapp/backend/' + 'getuserdetails.php',
		success: function(response) {
			if(response.status == 'failed') {
				document.cookie = "token=; path=/";
				window.location = "./index.html";
			}
			else {
				var user = response.data;
				$("#name").html(user.name);
			}
		},
		error: function(xhr, status, err) {
			console.log(err.toString());
		}
	});
}


function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
} 


function logout() {
	document.cookie = "token=; path=/";
	window.location = "./index.html";
}