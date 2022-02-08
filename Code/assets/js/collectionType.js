var $delCollectionButton = $('<button class="removeImage">Supprimer</button>');
var $vignette = $('<i class="far fa-image"></i>');

console.log("la feuille js est reçue bis");
// let j = -1;

function generateDeleteButton() {
	console.log($delCollectionButton);
	var $btn = $delCollectionButton.clone();
	$btn.on(
		"click",
		function () {
			//événement clic du bouton supprimer
			// $(this).parent("div").remove();
			// console.log($(this).parent("div").append($vignette));
			let index = $(this).parent("div").attr("id").slice(-1);
			$("#annonce_photos_" + index).remove();
			$(this).parent("div").remove();
			for (let i = 1; i < 4; i++) {
				$("#div_vignette_" + [i]).attr("id", "div_vignette_" + [i - 1]);
			}
			$(".vignette")
				.last()
				.after(
					"<div id='div_vignette_2' class='vignette'><i class='far fa-image'></i></div>"
				);
			collectionHolder.dataset.index--;
			for (let i = 1; i < 4; i++) {
				$("#annonce_photos_" + [i]).attr("id", "annonce_photos_" + [i - 1]);
				$("#annonce_photos_" + [i] + "_imageFile_file").attr(
					"id",
					"annonce_photos_" + [i - 1]
				);
			}
		}
		// $("#annonce_photos_" + index).remove();
	);
	return $btn;
}

// var vignette = document.createElement("i");
// vignette.classList.add("far");
// vignette.classList.add("fa-image");
// vignette.id = "vignette_" + [j];
console.log($vignette);
//   "<i class='far fa-image' id='vignette_" + [i] + "'></i>"
// );
// document.querySelector("#div_vignette_" + [j]).appendChild(vignette);

const addTagLink = document.createElement("a");
addTagLink.classList.add("bouton");
// console.log("il lit ça");
addTagLink.classList.add("add_tag_list");
addTagLink.href = "#";
addTagLink.innerText = "Ajouter une photo";
addTagLink.dataset.collectionHolderClass = "photos";

const newLinkLi = document.createElement("li").append(addTagLink);

const collectionHolder = document.querySelector("ul.photos");
collectionHolder.appendChild(addTagLink);

const addFormToCollection = (e) => {
	// console.log("il se passe bien un truc");
	const collectionHolder = document.querySelector(
		"." + e.currentTarget.dataset.collectionHolderClass
	);
	const item = document.createElement("li");

	item.innerHTML = collectionHolder.dataset.prototype.replace(
		/__name__/g,
		collectionHolder.dataset.index
	);
	collectionHolder.appendChild(item);

	collectionHolder.dataset.index++;
	console.log(collectionHolder.dataset.index);
	// addPhotoFormDeleteLink(item);

	for (let i = 0; i < 3; i++) {
		console.log($("#annonce_photos_" + [i] + "_imageFile_file"));
		$("#annonce_photos_" + [i] + "_imageFile_file").change(function () {
			$("#annonce_photos_" + [i] + "_imageFile_file").addClass("hidden");
			filePreviewArticle(this, i);
			console.log("il se passe bien un truc");
		});
	}
	// j++;
};

addTagLink.addEventListener("click", addFormToCollection);

// document.querySelectorAll("ul.photos li").forEach((photo) => {
//   addPhotoFormDeleteLink(photo);
// });

// const addPhotoFormDeleteLink = (item) => {
// 	const removeFormButton = document.createElement("button");
// 	removeFormButton.innerText = "Supprimer";
// 	item.append(removeFormButton);
// 	removeFormButton.addEventListener("click", (e) => {
// 		e.preventDefault();
// 		// remove the li for the tag form
// 		item.remove();
// 	});
// };
// };

let removeButton;

function filePreviewArticle(input, i) {
	console.log("truc déclenché");
	if (input.files && input.files[0]) {
		// console.log("truc déclenché ter");
		var reader = new FileReader();
		reader.onload = function (e) {
			// console.log("ça marche encore !");
			$("#div_vignette_" + [i])
				.html(
					'<div class="img_col">' +
						'<img class="preview" id="preview_' +
						i +
						'" src="' +
						e.target.result +
						'" width="450" height="auto"/>'
					// +
					// '<button class="removeImage">Supprimer</button>'
				)
				.append(generateDeleteButton());

			// removeButton = document.getElementsByClassName("removeImage");
			// console.log(removeButton);
			// console.log(j);
			// console.log(removeButton[j]);

			// removeButton[j].addEventListener("click", (e) => {
			//   e.preventDefault();
			//   // remove the li for the tag form
			//   // console.log($("#div_vignette_" + [i]));
			//   $("#div_vignette_" + [j]).html("");
			//   var vignette = document.createElement("i");
			//   vignette.classList.add("far");
			//   vignette.classList.add("fa-image");
			//   vignette.id = "vignette_" + [j];
			//   console.log(vignette);
			//   //   "<i class='far fa-image' id='vignette_" + [i] + "'></i>"
			//   // );
			//   document.querySelector("#div_vignette_" + [j]).appendChild(vignette);
			//   // removeButton[i].remove();
			//   j--;
			//   return j;
			// });
			// console.log(j);
			// $(".vich-image").after(
			//   "<p class=\"textPreview\">Pour information, l'image d'avatar choisie sera arrondie, et si elle n'est pas carrée, elle sera rognée.</p>"
			// );
		};
		reader.readAsDataURL(input.files[0]);
	}
}

// $("#annonce_photos_0_imageFile_file").change(function () {
//   console.log("truc déclenché");
//   filePreview(this);
// });

// test si jquery marche : jquery marche !
// $("body").css("background", "deepskyblue");
