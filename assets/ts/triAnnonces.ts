// condition qui permet de vérifier si on est face à un visiteur ou un user
if (document.querySelector("#visitorLat") != null) {
  let sessionStorage = window.sessionStorage;
  let data = JSON.parse(sessionStorage.getItem("position") as string);
  if (data) {
    setpos(data.lon, data.lat);
  } else {
    navigator.geolocation.getCurrentPosition(success, error);
  }
  function success(position: { coords: { longitude: any; latitude: any } }) {
    setpos(position.coords.longitude, position.coords.latitude);
    sessionStorage.setItem(
      "position",
      JSON.stringify({
        lat: position.coords.latitude,
        lon: position.coords.longitude,
      })
    );
  }

  function setpos(lon: any, lat: any) {
    (document.querySelector("#visitorLat") as HTMLInputElement).value = lat;
    (document.querySelector("#visitorLng") as HTMLInputElement).value = lon;
    (window as any).setMapView(
      lon,
      lat,
      "Votre localisation",
      radius ? (radius as HTMLInputElement).value : null
    );
  }

  function error() {
    (document.querySelector("#divDistance") as HTMLElement).classList.add(
      "nav-link"
    );
    (document.querySelector("#divDistance") as HTMLElement).classList.add(
      "disabled"
    );
  }
}

const searchByTagSelector = document.querySelector("#selectTri");
const filtreCategories = document.querySelector("#filtres_categorie");
const filtreEtat = document.querySelector("#etat-objet");
const distance = document.querySelector("#distance");
const tri = document.querySelector("#tri");
const categorie = document.querySelector("#categorie");
const etat = document.querySelector("#etat");
const radius = document.querySelector("#radius");
const localisation = document.querySelector("#localisation");
const lieuxUser = document.querySelector("#lieuxUser");
const form = document.querySelector("#formRecherche");
const contenuRecherche = document.querySelector("#titreRecherche");
const titre = document.querySelector("#site-search");

(searchByTagSelector as HTMLElement).addEventListener("change", (event) => {
  (tri as HTMLInputElement).value = (event.target as HTMLInputElement).value;
  (form as HTMLFormElement).submit();
});

(filtreCategories as HTMLElement).addEventListener("change", (event) => {
  (categorie as HTMLInputElement).value = (
    event.target as HTMLInputElement
  ).value;
  (form as HTMLFormElement).submit();
});

(filtreEtat as HTMLElement).addEventListener("change", (event) => {
  (etat as HTMLInputElement).value = (event.target as HTMLInputElement).value;
  (form as HTMLFormElement).submit();
});

(distance as HTMLElement).addEventListener("change", (event) => {
  (radius as HTMLInputElement).value = (event.target as HTMLInputElement).value;
  (form as HTMLFormElement).submit();
});
if (lieuxUser != null) {
  (lieuxUser as HTMLElement).addEventListener("change", (event) => {
    (localisation as HTMLInputElement).value = (
      event.target as HTMLInputElement
    ).value;
    (form as HTMLFormElement).submit();
  });
}

if (
  (filtreCategories as HTMLElement).querySelector(
    `option[value='${(categorie as HTMLInputElement).value}']`
  ) != null
) {
  (
    (filtreCategories as HTMLElement).querySelector(
      `option[value='${(categorie as HTMLInputElement).value}']`
    ) as HTMLOptionElement
  ).selected = true;
}

if (
  (filtreEtat as HTMLElement).querySelector(
    `option[value='${(etat as HTMLInputElement).value}']`
  ) != null
) {
  (
    (filtreEtat as HTMLElement).querySelector(
      `option[value='${(etat as HTMLInputElement).value}']`
    ) as HTMLOptionElement
  ).selected = true;
}

if (
  (searchByTagSelector as HTMLElement).querySelector(
    `option[value='${(tri as HTMLInputElement).value}']`
  ) != null
) {
  (
    (searchByTagSelector as HTMLElement).querySelector(
      `option[value='${(tri as HTMLInputElement).value}']`
    ) as HTMLOptionElement
  ).selected = true;
}

if (lieuxUser != null) {
  if (
    lieuxUser.querySelector(
      `option[value='${(localisation as HTMLInputElement).value}']`
    ) != null
  ) {
    (
      lieuxUser.querySelector(
        `option[value='${(localisation as HTMLInputElement).value}']`
      ) as HTMLOptionElement
    ).selected = true;
  }
}
(document.querySelector("#distance") as HTMLInputElement).value = (
  radius as HTMLInputElement
).value;

// refaire aussi sur état objet, tri, recherche
// recherche.innerHTML = contenuRecherche;
if ((contenuRecherche as HTMLInputElement).innerText != null) {
  (titre as HTMLInputElement).value = (
    contenuRecherche as HTMLElement
  ).innerText.slice(12, (contenuRecherche as HTMLElement).innerText.length);
}
