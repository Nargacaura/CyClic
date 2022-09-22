// variable du bouton supprimer
var $delCollectionButton = $(
  '<button class="removeImage btn btn-warning m-1">Supprimer</button>'
);
// variable de l'icone par défaut
var $vignette = $('<i class="far fa-image"></i>');

function generateDeleteButton() {
  var $btn = $delCollectionButton.clone();
  // au clic sur un bouton,
  $btn.on("click", function () {
    // index = index de l'id de l'élément parent de this
    let index = $(this).parent("div").attr("id").slice(-1);
    // on supprime l'élément #annonce_photos_index
    $("#annonce_photos_" + index).remove();
    // on supprime le div parent de this
    console.log($(this).parent("div"));
    $(this).parent("div").remove();

    // On modifie l'id des éléments #div_vignette_index en les reculant de 1
    for (let i = 1; i < 4; i++) {
      $("#div_vignette_" + [i]).attr("id", "div_vignette_" + [i - 1]);
    }
    // On rajoute après le dernier élément .vignette l'icone par défaut avec l'index 2
    $(".vignette")
      .last()
      .after(
        "<div id='div_vignette_2' class='vignette'><i class='far fa-image'></i></div>"
      );

    if (
      document.querySelector(
        "#vich_" + document.getElementById("photos").dataset.index - 1
      )
    ) {
      document
        .querySelector(
          ".vich_" + document.getElementById("photos").dataset.index - 1
        )
        .remove();
    }

    // même chose pour annonce_photos_index et annonce_photos_index_imageFile_file
    for (let i = 1; i < 4; i++) {
      $("#annonce_photos_" + [i]).attr("id", "annonce_photos_" + [i - 1]);
      // c'est normal que j'enlève le "_imageFile_file" ci-dessous ?...
      $("#annonce_photos_" + [i] + "_imageFile_file").attr(
        "id",
        "annonce_photos_" + [i - 1]
      );
    }
    document.getElementById("photos").dataset.index--;
  });
  return $btn;
}

const addTagLink = document.createElement("a");
addTagLink.classList.add("bouton");
addTagLink.classList.add("add_tag_list");
addTagLink.href = "#";
addTagLink.innerText = "Ajouter une photo";
addTagLink.style.margin = "1rem";
addTagLink.style.display = "block";
addTagLink.dataset.collectionHolderClass = "photos";

const newLinkLi = document.createElement("li").append(addTagLink);

document.querySelector(".container__galerie").after(addTagLink);

const addFormToCollection = (e) => {
  e.preventDefault();

  const collectionHolder = document.querySelector(
    "." + e.currentTarget.dataset.collectionHolderClass
  );

  if (
    !document.querySelector(".vich") &&
    !document.querySelector("#vich_" + collectionHolder.dataset.index - 1) &&
    collectionHolder.dataset.index < 3
  ) {
    const item = document.createElement("p");
    item.classList.add("vich");

    item.innerHTML = collectionHolder.dataset.prototype.replace(
      /__name__/g,
      collectionHolder.dataset.index
    );
    item.id = `vich_${collectionHolder.dataset.index}`;
    item.querySelector("label").remove();
    addTagLink.after(item);
    collectionHolder.dataset.index++;
  }
  for (let i = 0; i < 3; i++) {
    $("#annonce_photos_" + [i] + "_imageFile_file").change(function () {
      $("#annonce_photos_" + [i] + "_imageFile_file").addClass("hidden");
      filePreviewArticle(this, i);
      document.querySelector(".vich").classList.remove("vich");
    });
  }
};

addTagLink.addEventListener("click", addFormToCollection);

let removeButton;

function filePreviewArticle(input, i) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#div_vignette_" + [i])
        .html(
          '<div class="img_col">' +
            '<img class="preview" id="preview_' +
            i +
            '" src="' +
            e.target.result +
            '" width="450" height="auto"/>'
        )
        .append(generateDeleteButton());
    };
    reader.readAsDataURL(input.files[0]);
  }
}

let invalidFile = document.querySelector(".is-invalid");

console.log("one " + invalidFile);
if (typeof invalidFile != "undefined") {
  let constraintWarning = document.createElement("p");
  constraintWarning.style.color = "red";
  constraintWarning.style.textAlign = "center";
  constraintWarning.style.padding = "1rem";
  let warning =
    document.querySelector("#annonce_photos_0").children[0].children[1]
      .innerText;
  constraintWarning.innerHTML = warning;

  let index = invalidFile.id.slice(15, 16);

  $("#annonce_photos_" + index).remove();
  // on supprime le div parent de this
  document.querySelector("#div_vignette_" + index).remove();
  // On modifie l'id des éléments #div_vignette_index en les reculant de 1
  for (let i = 1; i < 4; i++) {
    $("#div_vignette_" + [i]).attr("id", "div_vignette_" + [i - 1]);
  }
  // On rajoute après le dernier élément .vignette l'icone par défaut avec l'index 2
  $(".vignette")
    .last()
    .after(
      "<div id='div_vignette_2' class='vignette'><i class='far fa-image'></i></div>"
    );
  collectionHolder.dataset.index--;
  // même chose pour annonce_photos_index et annonce_photos_index_imageFile_file
  for (let i = 1; i < 4; i++) {
    $("#annonce_photos_" + [i]).attr("id", "annonce_photos_" + [i - 1]);
    // c'est normal que j'enlève le "_imageFile_file" ci-dessous ?...
    $("#annonce_photos_" + [i] + "_imageFile_file").attr(
      "id",
      "annonce_photos_" + [i - 1]
    );
  }

  document.querySelector("#annonce_photos").appendChild(constraintWarning);
}
