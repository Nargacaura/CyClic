// Initialisation des données
var data = "";

// API OpenCage: clé et URL
var OpenCageAPIKey = "5073f8b958324db5b548afbc8d27c280";
var APIURL = "https://api.opencagedata.com/geocode/v1/json";

function write_geolocation(data, XHReq){
    data = JSON.parse(XHReq.responseText);
    
    // Récolte des champs à modifier
    var coordInput = document.getElementsByClassName("coordonnees")[0];
    var inputVoie = document.getElementsByClassName("voie")[0];
    var inputCP = document.getElementsByClassName("CP")[0];
    var inputVille = document.getElementsByClassName("ville")[0];
    
    // dans la page d'accueil...
    if(coordInput){
        var localisation = data.results[0].formatted;

        // Insertion des coordonnées
        var coordinates = localisation;
        coordInput.value = coordinates;
    } 
    
    // dans les champs de localisation...
    else if (inputVoie && inputCP && inputVille) {
        var components = data.results[0].components;

        // ---
        // name: house
        // aliases:
        //     - building
        //     - public_building
        //     - isolated_dwelling
        //     - farmland
        //     - allotments
        // ---

        if (components.house_number){
            var numero_voie = `${components.house_number}`;
        } else if (components.housenumber) {
            var numero_voie = `${components.housenumber}`;
        } else if (components.street_number) {
            var numero_voie = `${components.street_number}`;
        } else if (components.house) {
            var numero_voie = `${components.house},`;
        } else if (components.building) {
            var numero_voie = `${components.building},`;
        } else if (components.public_building) {
            var numero_voie = `${components.public_building},`;
        } else if (components.isolated_dwelling) {
            var numero_voie = `${components.isolated_dwelling},`;
        } else if (components.farmland) {
            var numero_voie = `${components.farmland},`;
        } else if (components.allotments) {
            var numero_voie = `${components.allotents},`;
        } else {
            var numero_voie = "";
        }
        // voie
        // en attendant de voir comment le reformater en switch case... plein de conditionnelles if...else.
        if(components.road) {
            var voie = `${numero_voie} ${components.road}`;
        } else if (components.street) {
            var voie = `${numero_voie} ${components.street}`;
        } else if (components.footway) {
            var voie = `${numero_voie} ${components.footway}`;
        } else if (components.path) {
            var voie = `${numero_voie} ${components.path}`;
        } else if (components.square) {
            var voie = `${numero_voie} ${components.square}`;
        } else if (components.place) {
            var voie = `${numero_voie} ${components.place}`;
        } else {
            var voie = "Voie inconnue";
        }
        inputVoie.value = voie;

        // code postal
        var codePostal = components.postcode;
        inputCP.value = codePostal;

        // ville
        if(components.city) {
            var ville = components.city;
        } else if (components.town) {
            var ville = components.town;
        } else {
            var ville = components.township;
        }
        inputVille.value = ville;
    }

    // sinon...
    else {
        alert("Géolocalisation indisponible.")
    }
}

function geolocate(){
    // Vérifions d'abord si la géolocalisation est possible...
    if("geolocation" in navigator) {
        // Options de géolocalisation Mozilla
        var options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
        };

        // Si la géolocalisation réussit:
        function success(position){ 
            // Récolte de la latitude et de la longitude
            var latitude = `${position.coords.latitude}`;
            var longitude = `${position.coords.longitude}`

            // Génération de la requête OpenCage
            var request = `${APIURL}?key=${OpenCageAPIKey}&q=${encodeURIComponent(latitude + ',' + longitude)}&no_annotations=1&pretty=1`;

            var XHReq = new XMLHttpRequest();
            XHReq.open('GET', request, true);

            // Si la requête charge...
            XHReq.onload = function() {
                // ... et que ça réussit...
                if (XHReq.status === 200){
                    // ... écrire dans les inputs la localisation
                    write_geolocation(data, XHReq);
                }
                
                // ... mais que ça ne marche pas à cause des actions involontaires de l'utilisateur...
                else if (XHReq.status <= 500) {
                    // ... signaler l'erreur
                    data = JSON.parse(XHReq.responseText);
                    console.error("Géocodage impossible: erreur " + XHReq.status + ": " + data.status.message);
                }
                
                // ... mais que ça ne marche pas à cause d'un problème technique côté serveur...
                else {
                    // ... prévenir le développeur
                    console.error("Géolocalisation impossible: une erreur du côté du serveur est survenue.")
                }
            }

            // Si la requête n'arrive pas à se connecter...
            XHReq.onerror = function() {
                // ... avertir de ce couac.
                console.warn("Connexion au serveur impossible.")
            }

            // On envoie?
            XHReq.send();
        }

        // Dans le cas contraire, si ça coince quelque part:
        function fail(error){
            alert(`Une erreur s'est produite: ${error.message} (erreur ${error.code}))`);
        }

        // Le processus de géolocalisation est lancé, donnant donc la main à l'une des 2 fonctions ci-dessus.
        navigator.geolocation.getCurrentPosition(success, fail, options);

    }
    
    // Si elle ne l'est pas...
    else {
        alert("Nous n'avons pas pu démarrer le processus de géolocalisation.");
    }
}

const geolocator = document.querySelector(".geolocation");
geolocator.addEventListener("click", geolocate);