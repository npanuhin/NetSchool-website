var
	html = document.getElementsByTagName("html")[0],
	main = document.getElementsByTagName("main")[0],

	menu_button = document.getElementsByClassName("menu_icon_wrapper")[0],
	logout_button = document.getElementsByClassName("exit_icon")[0],

	menu = document.getElementsByClassName("menu")[0],
	marks = document.getElementsByClassName("marks")[0];


Event.add(window, "load", () => {

	main.style.minHeight = menu.clientHeight + "px";

	Event.add(menu_button, "click", () => {
		html.classList.add("loaded");

		if (menu.classList.contains("shown")) {
			menu_button.classList.remove("active");
			menu.classList.remove("shown");
			marks.style.transform = "translateY(0px)";

			setTimeout(() => {
				main.style.minHeight = menu.clientHeight + "px";
			}, 300);

		} else {
			menu_button.classList.add("active");
			menu.classList.add("shown");
			marks.style.transform = "translateY(" + menu.clientHeight + "px)";

			main.style.minHeight = main.clientHeight + menu.clientHeight + "px";
			
		}
	});

	Event.add(logout_button, "click", () => {
		html.classList.add("loaded");
		
		ajax(
			"POST",
			"/src/logout.php",
			{},
			(req) => {
				if (req.responseText == "success") {
					window.location = "/login/";
				} else {
					alert("Error");
					alert(req.responseText);
				}
			},
			(req) => {
				alert("Error");
				alert(req.responseText);
			}
		);
	});

});