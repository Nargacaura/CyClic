import $ from "jquery";

const maxAtteint = document.createElement("p");
maxAtteint.innerText = "Maximum de photos atteint";
maxAtteint.style.backgroundColor = "red";
maxAtteint.style.borderRadius = "5px";
maxAtteint.style.color = "white";

const fileMax = document.querySelector("#annonce_photos_2");

const observer = new MutationObserver(function (mutations_list) {
  mutations_list.forEach(function (mutation) {
    mutation.removedNodes.forEach(function (removed_node) {
      if ((removed_node as any).id == "annonce_photos_2") {
        observer.disconnect();
      }
    });
  });
});

let addTagLink = document.createElement("a");
addTagLink.style.display = "block";
addTagLink.classList.add("bouton");
addTagLink.classList.add("add_photo_list");
addTagLink.style.setProperty("margin", "auto");
addTagLink.href = "#";
addTagLink.innerText = "Ajouter une photo";
addTagLink.dataset.collectionHolderClass = "photosEdit";

let newLinkLi = document.createElement("li").append(addTagLink);

const collectionHolder = document.querySelector("ul.photosEdit");

const array = (document.querySelector("ul#photos") as Element).children;
for (let i = 0; i < array.length; i++) {
  array[i].id = `li_photos_${i}`;
}

(document.getElementById("annonce_localisation") as HTMLElement).before(
  addTagLink
);

let addFormToCollection = (e: Event) => {
  e.preventDefault();
  const collectionHolder = document.querySelector(
    `.${(e.currentTarget as HTMLElement).dataset.collectionHolderClass}`
  );

  if (
    !document.querySelector(".vich") &&
    !document.querySelector(
      `#annonce_photos_${
        parseInt((collectionHolder as HTMLElement).dataset.index as string) - 1
      }_imageFile_file`
    ) &&
    parseInt((collectionHolder as HTMLElement).dataset.index as string) < 3
  ) {
    const item = document.createElement("li");
    item.id = `li_photos_${(collectionHolder as HTMLElement).dataset.index}`;
    item.classList.add("vich");

    item.innerHTML = (
      (collectionHolder as HTMLElement).dataset.prototype as string
    ).replace(
      /__name__/g,
      (collectionHolder as HTMLElement).dataset.index as string
    );
    (collectionHolder as HTMLElement).append(item);

    (collectionHolder as HTMLElement).dataset.index = (
      parseInt((collectionHolder as HTMLElement).dataset.index as string) + 1
    ).toString();

    for (let i = 0; i < 3; i++) {
      $(`#annonce_photos_${[i]}_imageFile_file`).on("change", function () {
        $(`#annonce_photos_${[i]}_imageFile_file`).addClass("hidden");
        filePreviewArticle(this, i);
        let $delCollectionButton = createButton();
        (document.querySelector(".vich") as HTMLElement).classList.remove(
          "vich"
        );

        item.append($delCollectionButton);
        $delCollectionButton.addEventListener("click", function () {
          (this.previousSibling as HTMLElement).remove();
          decalageIndex(this);
        });
      });
    }
  }
};

testMax();

addTagLink.addEventListener("click", addFormToCollection);

let previousPics = document.querySelectorAll(".vich-image");

previousPics.forEach((elem) => {
  let $delCollectionButton = createButton();
  (elem.firstChild as HTMLElement).classList.add("hidden");

  elem.insertAdjacentElement("beforeend", $delCollectionButton);
  $delCollectionButton.addEventListener("click", function () {
    (this.parentNode as HTMLElement).remove();
    decalageIndex(this);
  });
});

let filePreviewArticle = (input: any, i: any) => {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $(`#annonce_photos_${[i]}_imageFile_file`).after(
        `<div class='img_col'><img class='preview' id='preview_${i}' src='${
          (e.target as FileReader).result
        }' width='450' height='auto'/>`
      );
    };
    reader.readAsDataURL(input.files[0]);
  }
  testMax();
};

function decalageIndex(element: HTMLElement) {
  element.remove();
  (collectionHolder as HTMLElement).dataset.index = (
    parseInt((collectionHolder as HTMLElement).dataset.index as string) - 1
  ).toString();

  for (let i = 1; i < 4; i++) {
    $(`#annonce_photos_${[i]}`).attr("id", `annonce_photos_${[i - 1]}`);
    // c'est normal que j'enlève le "_imageFile_file" ci-dessous ?...
    $(`#annonce_photos_${[i]}_imageFile_file`).attr(
      "id",
      `annonce_photos_${[i - 1]}_imageFile_file`
    );
  }

  observer.observe(document.querySelector("#li_photos_2") as HTMLElement, {
    subtree: false,
    childList: true,
  });
  if (typeof fileMax == "undefined") {
    maxAtteint.replaceWith(addTagLink);
  }
}

function createButton() {
  let $delCollectionButton = document.createElement("button");
  $delCollectionButton.innerText = "Supprimer";
  $delCollectionButton.classList.add("removeImage");
  $delCollectionButton.classList.add("btn");
  $delCollectionButton.classList.add("btn-warning");
  $delCollectionButton.style.margin = "1rem";
  $delCollectionButton.type = "button";

  return $delCollectionButton;
}

function testMax() {
  if (fileMax != null) {
    addTagLink.replaceWith(maxAtteint);
  }
}
