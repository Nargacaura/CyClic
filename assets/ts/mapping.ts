import "../../node_modules/leaflet/dist/leaflet.css";
import L from "leaflet";

let mapElement = document.getElementById("map");

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
  iconRetinaUrl: require("leaflet/dist/images/marker-icon-2x.png"),
  iconUrl: require("leaflet/dist/images/marker-icon.png"),
  shadowUrl: require("leaflet/dist/images/marker-shadow.png"),
});
var map = L.map("map");
if (!map._lastCenter) map.setView([48.8574776804027, 2.289697034198719], 13);
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution:
    '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);

(window as any).setMapView = setMapView;
function setMapView(
  lon: string,
  lat: string,
  markMessage: string = "",
  radius: number = 10
) {
  map.setView([lat, lon], 10);
  if (typeof markMessage === "string") {
    L.marker([lat, lon]).addTo(map).bindPopup(markMessage).openPopup();
  }
  if (!isNaN(radius)) {
    map.setZoom(14 - Math.floor(Math.log10(radius) * 3));
    L.circle([lat, lon], {
      color: "turquoise",
      fillColor: "#18edb1",
      fillOpacity: 0.04,
      radius: radius * 1000,
    }).addTo(map);
  }
}

// centre la map avec la localisation
if (
  (mapElement as HTMLElement).dataset.lon &&
  (mapElement as HTMLElement).dataset.lat
) {
  setMapView(
    (mapElement as HTMLElement).dataset.lon as string,
    (mapElement as HTMLElement).dataset.lat as string,
    (mapElement as HTMLElement).dataset.message,
    parseFloat((mapElement as HTMLElement).dataset.radius as string)
  );
}

// creation des marques sur la carte avec une popup qui contient les données de l'annonce liée
let mapData = document.getElementById("mapData");
let mark: { addTo: (arg0: any) => void; bindPopup: (arg0: any) => void };
if (mapData) {
  let locs = JSON.parse(mapData.innerHTML);
  locs.forEach(
    (locData: { lat: any; lon: any; annonce: any; title: any; photo: any }) => {
      mark = L.marker([locData.lat, locData.lon]);
      mark.addTo(map);
      mark.bindPopup(
        makePopupContent(locData.annonce, locData.title, locData.photo)
      );
    }
  );
}

// affichage via des marqueurs des localisation de l'utilisateur
let showBtns = Array.from(document.getElementsByClassName("showOnMap"));
let locInfo = Array.from(document.getElementsByClassName("adresseMap"));
if (showBtns != null && showBtns.length > 0) {
  let index = 0;
  let same = showBtns.length == locInfo.length;

  setMapView(
    (showBtns[0] as HTMLElement).dataset.lon as string,
    (showBtns[0] as HTMLElement).dataset.lat as string
  );

  showBtns.forEach((btn) => {
    L.marker([
      (btn as HTMLElement).dataset.lat,
      (btn as HTMLElement).dataset.lon,
    ])
      .addTo(map)
      .bindPopup(same ? locInfo[index].innerHTML : "")
      .openPopup();
    btn.addEventListener("click", (e) => {
      setMapView(
        (btn as HTMLElement).dataset.lon as string,
        (btn as HTMLElement).dataset.lat as string
      );
    });
    index++;
  });
}

function makePopupContent(id: any, title: any, photo: any) {
  const imgSize = 150;
  let popUpContent: HTMLDivElement;
  let popUpElem: HTMLDivElement;
  popUpContent = document.createElement("div");
  popUpContent.classList.add("text-center", "container");
  let image = photo
    ? makeImage(`/img/imgAnnonces/${photo}`, imgSize, "photo_annonce")
    : makeImage("/img/imgAnnonces/default.png", imgSize, "photo_annonce");
  image.classList.add("img-fluid");
  popUpElem = document.createElement("h6");
  popUpElem.innerText = title;
  popUpElem.classList.add("text-center");
  popUpContent.appendChild(popUpElem);
  popUpContent.appendChild(image);
  popUpElem = document.createElement("div");
  popUpElem.classList.add("row", "justify-content-md-center");
  popUpContent.appendChild(popUpElem);
  popUpElem.appendChild(document.createElement("button"));
  popUpElem.innerText = "Voir l'annonce";
  popUpElem.classList.add("bouton_margin", "col");
  popUpElem.addEventListener("click", (e: any) => {
    window.location.href = `/annonce/${id}`;
  });
  return popUpContent;
}

function makeImage(src: string, maxSize: number, alt: string) {
  let img = document.createElement("img");
  img.src = src;
  if (img.width > img.height) {
    img.height *= maxSize / img.width;
    img.width = maxSize;
  } else {
    img.width *= maxSize / img.height;
    img.height = maxSize;
  }
  img.alt = alt;

  return img;
}
