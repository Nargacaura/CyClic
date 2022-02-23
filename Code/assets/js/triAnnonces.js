const searchByTagSelector = document.querySelector("#selectTri");
const filtreCategories = document.querySelector("#filtres_categorie");
const filtreEtat = document.querySelector("#etat-objet");
const filtreDistance = document.querySelector("#distance");
const tri = document.querySelector("#tri");
const categorie = document.querySelector("#categorie");
const etat = document.querySelector("#etat");
const radius = document.querySelector("#radius");
const form = document.querySelector("#formRecherche");
// fonction de callback: fonction exécuter après ou dans une fonction
// fonction anonyme: fonction qui n'a pas de nom
searchByTagSelector.addEventListener("change", (event) => {
	tri.value = event.target.value;
	form.submit();
	// this fait référence à la fonction (certainement)
	//document.location = '/annonce-by-tag/' + event.target.value
	// backtick = alt gr + 7
	// document.location = `/annonce/tri/${event.target.value}`;
});

filtreCategories.addEventListener("change", (event) => {
	categorie.value = event.target.value;
	form.submit();
});

filtreEtat.addEventListener("change", (event) => {
	etat.value = event.target.value;
	form.submit();
});

distance.addEventListener("change", (event) => {
	radius.value = event.target.value;
	form.submit();
});
