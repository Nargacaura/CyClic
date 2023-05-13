const userIcon = document.querySelector("#userIconDesktop");
const userIconMobile = document.querySelector("#userIconMobile");

if (screen.width > 768) {
  (userIcon as HTMLElement).addEventListener("mouseenter", function () {
    (
      document.querySelector("#userMenuDesktop") as HTMLElement
    ).classList.remove("userIconOff");
    (document.querySelector("#userMenuDesktop") as HTMLElement).classList.add(
      "userIconOn"
    );
  });

  (document.querySelector("#userMenuDesktop") as HTMLElement).addEventListener(
    "mouseleave",
    function (e) {
      (e.target as HTMLElement).classList.remove("userIconOn");
      (e.target as HTMLElement).classList.add("userIconOff");
    }
  );
} else {
  (userIconMobile as HTMLElement).addEventListener(
    "click",
    function (e: Event) {
      e.preventDefault();
      (
        document.querySelector("#userMenuMobile") as HTMLElement
      ).classList.toggle("userIconOff");
      (
        document.querySelector("#userMenuMobile") as HTMLElement
      ).classList.toggle("userIconOn");
    }
  );
}
