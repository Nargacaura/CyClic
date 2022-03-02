console.log(screen.width);
const userIcon = document.querySelector("#userIconDesktop");
const userIconMobile = document.querySelector("#userIconMobile");
console.log(document.querySelector(".nav_menu_desktop"));
if (screen.width > 768) {
	userIcon.addEventListener("mouseenter", function () {
		// console.log("mouseenter activé");
		// console.log(document.querySelector("#userMenu"));
		document.querySelector("#userMenuDesktop").classList.remove("userIconOff");
		document.querySelector("#userMenuDesktop").classList.add("userIconOn");
	});

	document
		.querySelector("#userMenuDesktop")
		.addEventListener("mouseleave", function (e) {
			// console.log("mouseleave activé");
			e.target.classList.remove("userIconOn");
			e.target.classList.add("userIconOff");
		});
	z;
} else {
	userIconMobile.addEventListener("click", function (e) {
		e.preventDefault();
		// console.log("mouseenter activé");
		// console.log(document.querySelector("#userMenu"));
		document.querySelector("#userMenuMobile").classList.toggle("userIconOff");
		document.querySelector("#userMenuMobile").classList.toggle("userIconOn");
	});
}
