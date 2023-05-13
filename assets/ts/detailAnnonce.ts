let vignettes = document.querySelectorAll(".product_image_1");

vignettes.forEach(function (vignette: any) {
  vignette.addEventListener("click", function () {
    let src = (vignette as HTMLImageElement).src;
    (document.querySelector(".product_image") as HTMLImageElement).src = src;
  });
});
