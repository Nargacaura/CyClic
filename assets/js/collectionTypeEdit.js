const maxAtteint = document.createElement("p");
maxAtteint.innerText = "Maximum de photos atteint";
maxAtteint.style.backgroundColor = "red";
maxAtteint.style.borderRadius = "5px";
maxAtteint.style.color = "white";

const observer = new MutationObserver(function (mutations_list) {
  mutations_list.forEach(function (mutation) {
    mutation.removedNodes.forEach(function (removed_node) {
      if (removed_node.id == "annonce_photos_2") {
        console.log("#child has been removed");
        observer.disconnect();
      }
    });
  });
});

const addTagLink = document.createElement("a");
addTagLink.style.display = "block";
addTagLink.classList.add("bouton");
addTagLink.classList.add("add_photo_list");
addTagLink.style = "margin: auto";
addTagLink.href = "#";
addTagLink.innerText = "Ajouter une photo";
addTagLink.dataset.collectionHolderClass = "photosEdit";

const newLinkLi = document.createElement("li").append(addTagLink);

const collectionHolder = document.querySelector("ul.photosEdit");

const array = document.querySelector("ul#photos").children;
console.log(array);
for (let i = 0; i < array.length; i++) {
  array[i].id = "li_photos_" + i;
}

document.getElementById("annonce_localisation").before(addTagLink);

const addFormToCollection = (e) => {
  e.preventDefault();
  const collectionHolder = document.querySelector(
    "." + e.currentTarget.dataset.collectionHolderClass
  );
  console.log(collectionHolder);

  if (
    !document.querySelector(".vich") &&
    !document.querySelector(
      "#annonce_photos_" +
        collectionHolder.dataset.index -
        1 +
        "_imageFile_file"
    ) &&
    collectionHolder.dataset.index < 3
  ) {
    const item = document.createElement("li");
    item.id = "li_photos_" + collectionHolder.dataset.index;
    item.classList.add("vich");

    item.innerHTML = collectionHolder.dataset.prototype.replace(
      /__name__/g,
      collectionHolder.dataset.index
    );
    collectionHolder.append(item);

    collectionHolder.dataset.index++;

    for (let i = 0; i < 3; i++) {
      $("#annonce_photos_" + [i] + "_imageFile_file").change(function () {
        $("#annonce_photos_" + [i] + "_imageFile_file").addClass("hidden");
        filePreviewArticle(this, i);
        let $delCollectionButton = createButton();
        document.querySelector(".vich").classList.remove("vich");

        item.append($delCollectionButton);
        $delCollectionButton.addEventListener("click", function () {
          console.log(this);
          console.log(this.previousSibling);
          this.previousSibling.remove();
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
  elem.firstChild.classList.add("hidden");

  elem.insertAdjacentElement("beforeend", $delCollectionButton);
  console.log(elem.insertAdjacentElement("beforeend", $delCollectionButton));
  console.log("ok");
  $delCollectionButton.addEventListener("click", function () {
    this.parentNode.remove();
    decalageIndex(this);
  });
});

function filePreviewArticle(input, i) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#annonce_photos_" + [i] + "_imageFile_file").after(
        "<div class='img_col'>" +
          "<img class='preview' id='preview_" +
          i +
          "' src='" +
          e.target.result +
          "' width='450' height='auto'/>"
      );
    };
    reader.readAsDataURL(input.files[0]);
  }
  testMax();
}

function decalageIndex(element) {
  element.remove();
  collectionHolder.dataset.index--;

  for (let i = 1; i < 4; i++) {
    $("#annonce_photos_" + [i]).attr("id", "annonce_photos_" + [i - 1]);
    // c'est normal que j'enlève le "_imageFile_file" ci-dessous ?...
    $("#annonce_photos_" + [i] + "_imageFile_file").attr(
      "id",
      "annonce_photos_" + [i - 1] + "_imageFile_file"
    );
  }

  observer.observe(document.querySelector("#li_photos_2"), {
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
  let fileMax = document.querySelector("#annonce_photos_2");
  console.log(fileMax);
  if (fileMax != null) {
    console.log("max atteint");
    addTagLink.replaceWith(maxAtteint);
  }
}
