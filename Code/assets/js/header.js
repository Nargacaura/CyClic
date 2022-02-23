console.log("header");
const userIcon = document.querySelector("#userIcon");

if (userIcon) {
	userIcon.addEventListener("mouseenter", function () {
		console.log("mouseenter activé");
		console.log(document.querySelector("#userMenu"));
		document.querySelector("#userMenu").classList.remove("userIconOff");
		document.querySelector("#userMenu").classList.add("userIconOn");
	});

	document
		.querySelector("#userMenu")
		.addEventListener("mouseleave", function (e) {
			console.log("mouseleave activé");
			e.target.classList.remove("userIconOn");
			e.target.classList.add("userIconOff");
		});
}
