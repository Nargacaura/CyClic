// Initialisation des données
var data = "";

// API OpenCage: clé et URL
var OpenCageAPIKey = "5073f8b958324db5b548afbc8d27c280";
var APIURL = "https://api.opencagedata.com/geocode/v1/json";

let geolocator = document.querySelector(".geolocation");
if (!geolocator) geolocator = document.getElementById("geolocBtn");
else geolocator.addEventListener("click", geolocate);

function write_geolocation(data: any, XHReq: XMLHttpRequest) {
  let numero_voie: string;
  let voie: string;
  let codePostal: string;
  let ville: string;

  data = JSON.parse(XHReq.responseText);

  // Récolte des champs à modifier
  var coordInput = document.getElementsByClassName("coordonnees")[0];
  var inputVoie = document.getElementsByClassName("voie")[0];
  var inputCP = document.getElementsByClassName("CP")[0];
  var inputVille = document.getElementsByClassName("ville")[0];

  var inputLat = document.getElementById("localisation_latitude");
  var inputLon = document.getElementById("localisation_longitude");
  var components = data.results[0].components;
  var latitude = data.results[0].geometry.lat;
  var longitude = data.results[0].geometry.lng;

  let locUser_ville = document.querySelector(
    "#registration_form_locUser___name___ville"
  );
  let locUser_CP = document.querySelector(
    "#registration_form_locUser___name___codePostal"
  );
  let locUser_rue = document.querySelector(
    "#registration_form_locUser___name___rue"
  );
  let locUser_longitude = document.querySelector(
    "#registration_form_locUser___name___longitude"
  );
  let locUser_latitude = document.querySelector(
    "#registration_form_locUser___name___latitude"
  );

  if (components.house_number) {
    numero_voie = `${components.house_number}`;
  } else if (components.housenumber) {
    numero_voie = `${components.housenumber}`;
  } else if (components.street_number) {
    numero_voie = `${components.street_number}`;
  } else if (components.house) {
    numero_voie = `${components.house},`;
  } else if (components.building) {
    numero_voie = `${components.building},`;
  } else if (components.public_building) {
    numero_voie = `${components.public_building},`;
  } else if (components.isolated_dwelling) {
    numero_voie = `${components.isolated_dwelling},`;
  } else if (components.farmland) {
    numero_voie = `${components.farmland},`;
  } else if (components.allotments) {
    numero_voie = `${components.allotents},`;
  } else {
    numero_voie = "";
  }
  // voie
  // en attendant de voir comment le reformater en switch case... plein de conditionnelles if...else.
  if (components.road) {
    voie = `${numero_voie} ${components.road}`;
  } else if (components.street) {
    voie = `${numero_voie} ${components.street}`;
  } else if (components.footway) {
    voie = `${numero_voie} ${components.footway}`;
  } else if (components.path) {
    voie = `${numero_voie} ${components.path}`;
  } else if (components.square) {
    voie = `${numero_voie} ${components.square}`;
  } else if (components.place) {
    voie = `${numero_voie} ${components.place}`;
  } else {
    voie = "Voie inconnue";
  }

  // code postal
  codePostal = components.postcode;

  // ville
  if (components.city) {
    ville = components.city;
  } else if (components.town) {
    ville = components.town;
  } else {
    ville = components.township;
  }

  // dans la page d'accueil...
  if (coordInput) {
    var localisation = `${voie}, ${codePostal} ${ville}, ${components.country}`;

    // Insertion des coordonnées
    var coordinates = localisation;
    (coordInput as HTMLInputElement).value = coordinates;
  }

  // dans les champs de localisation...
  if (inputVoie && inputCP && inputVille) {
    (inputVoie as HTMLInputElement).value = voie;
    (inputCP as HTMLInputElement).value = codePostal;
    (inputVille as HTMLInputElement).value = ville;
    (inputLon as HTMLInputElement).value = longitude;
    (inputLat as HTMLInputElement).value = latitude;
    (window as any).setMapView(longitude, latitude, "Vous êtes ici");
  } else if (locUser_ville && locUser_CP && locUser_rue) {
    (locUser_ville as HTMLInputElement).value = ville;
    (locUser_CP as HTMLInputElement).value = codePostal;
    (locUser_rue as HTMLInputElement).value = voie;
    (locUser_longitude as HTMLInputElement).value =
      data.results[0].geometry.lng;
    (locUser_latitude as HTMLInputElement).value = data.results[0].geometry.lat;

    (
      document.querySelector(
        "#registration_form_autoCompleteLocalisation"
      ) as HTMLInputElement
    ).value = `${(locUser_ville as HTMLInputElement).value} ${
      (locUser_CP as HTMLInputElement).value
    } ${(locUser_rue as HTMLInputElement).value}`;
  }
}

function geolocate() {
  // Vérifions d'abord si la géolocalisation est possible...
  if ("geolocation" in navigator) {
    // Options de géolocalisation Mozilla
    var options = {
      enableHighAccuracy: true,
      timeout: 5000,
      maximumAge: 0,
    };

    let sessionStorage = window.sessionStorage;
    let data = JSON.parse(sessionStorage.getItem("position") as string);

    if (data) {
      onSuccess(data.lon, data.lat);
    } else {
      // Le processus de géolocalisation est lancé, donnant donc la main à l'une des 2 fonctions ci-dessus.
      navigator.geolocation.getCurrentPosition(success, fail, options);
    }
    // Si la géolocalisation réussit:
    function success(position) {
      // Récolte de la latitude et de la longitude
      onSuccess(`${position.coords.longitude}`, `${position.coords.latitude}`);
    }

    function onSuccess(longitude: string, latitude: string) {
      // Génération de la requête OpenCage
      var request = `${APIURL}?key=${OpenCageAPIKey}&q=${encodeURIComponent(
        `${latitude},${longitude}`
      )}&no_annotations=1&pretty=1`;

      var XHReq = new XMLHttpRequest();
      XHReq.open("GET", request, true);

      // Si la requête charge...
      XHReq.onload = function () {
        // ... et que ça réussit...
        if (XHReq.status === 200) {
          // ... écrire dans les inputs la localisation
          write_geolocation(data, XHReq);
        }

        // ... mais que ça ne marche pas à cause des actions involontaires de l'utilisateur...
        else if (XHReq.status <= 500) {
          // ... signaler l'erreur
          data = JSON.parse(XHReq.responseText);
          console.error(
            `Géocodage impossible: erreur ${XHReq.status}: ${data.status.message}`
          );
        }

        // ... mais que ça ne marche pas à cause d'un problème technique côté serveur...
        else {
          // ... prévenir le développeur
          console.error(
            "Géolocalisation impossible: une erreur du côté du serveur est survenue."
          );
        }
      };

      // Si la requête n'arrive pas à se connecter...
      XHReq.onerror = function () {
        // ... avertir de ce couac.
        console.warn("Connexion au serveur impossible.");
      };

      // On envoie?
      XHReq.send();
    }

    // Dans le cas contraire, si ça coince quelque part:
    function fail(error: any) {
      alert(
        `Une erreur s'est produite: ${error.message} (erreur ${error.code}))`
      );
    }
  }

  // Si elle ne l'est pas...
  else {
    alert("Nous n'avons pas pu démarrer le processus de géolocalisation.");
  }
}
