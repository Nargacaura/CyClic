// condition qui permet de vérifier si on est face à un visiteur ou un user
if (document.querySelector("#visitorLat") != null) {
  let sessionStorage = window.sessionStorage;
  let data = JSON.parse(sessionStorage.getItem("position"));
  if (data) {
    setpos(data.lon, data.lat);
  } else {
    navigator.geolocation.getCurrentPosition(success, error);
  }
  function success(position) {
    setpos(position.coords.longitude, position.coords.latitude);
    sessionStorage.setItem(
      "position",
      JSON.stringify({
        lat: position.coords.latitude,
        lon: position.coords.longitude,
      })
    );
  }

  function setpos(lon, lat) {
    document.querySelector("#visitorLat").value = lat;
    document.querySelector("#visitorLng").value = lon;
    setMapView(lon, lat, "Votre localisation", radius ? radius.value : null);
  }

  function error() {
    document.querySelector("#divDistance").classList.add("nav-link");
    document.querySelector("#divDistance").classList.add("disabled");
    console.log("erreur géoloc");
  }
}

const searchByTagSelector = document.querySelector("#selectTri");
const filtreCategories = document.querySelector("#filtres_categorie");
const filtreEtat = document.querySelector("#etat-objet");
const filtreDistance = document.querySelector("#distance");
const tri = document.querySelector("#tri");
const categorie = document.querySelector("#categorie");
const etat = document.querySelector("#etat");
const radius = document.querySelector("#radius");
const localisation = document.querySelector("#localisation");
const lieuxUser = document.querySelector("#lieuxUser");
const form = document.querySelector("#formRecherche");
const contenuRecherche = document.querySelector("#titreRecherche");
const titre = document.querySelector("#site-search");
searchByTagSelector.addEventListener("change", (event) => {
  tri.value = event.target.value;
  form.submit();
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
if (lieuxUser != null) {
  lieuxUser.addEventListener("change", (event) => {
    localisation.value = event.target.value;
    form.submit();
  });
}

if (
  filtreCategories.querySelector("option[value='" + categorie.value + "']") !=
  null
) {
  filtreCategories.querySelector(
    "option[value='" + categorie.value + "']"
  ).selected = true;
}

if (filtreEtat.querySelector("option[value='" + etat.value + "']") != null) {
  filtreEtat.querySelector(
    "option[value='" + etat.value + "']"
  ).selected = true;
}

if (
  searchByTagSelector.querySelector("option[value='" + tri.value + "']") != null
) {
  searchByTagSelector.querySelector(
    "option[value='" + tri.value + "']"
  ).selected = true;
}

if (lieuxUser != null) {
  if (
    lieuxUser.querySelector("option[value='" + localisation.value + "']") !=
    null
  ) {
    lieuxUser.querySelector(
      "option[value='" + localisation.value + "']"
    ).selected = true;
  }
}
document.querySelector("#distance").value = radius.value;

// refaire aussi sur état objet, tri, recherche
// recherche.innerHTML = contenuRecherche;
if (contenuRecherche.innerText != null) {
  titre.value = contenuRecherche.innerText.slice(
    12,
    contenuRecherche.innerText.length
  );
}
