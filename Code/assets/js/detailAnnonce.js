// console.log("activé");
let vignettes = document.querySelectorAll(".product_image_1");

vignettes.forEach(function (vignette) {
  vignette.addEventListener("click", function () {
    let src = vignette.src;
    document.querySelector(".product_image").src = src;
  });
});
