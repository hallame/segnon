//Pour le menu
document.getElementById('menu-toggle').addEventListener('click', function() {
    const menu = document.querySelector('.menu');
    menu.classList.toggle('active');
    
    // Ajout pour afficher les éléments du right-section en mobile
    const rightSection = document.querySelector('.right-section');
    rightSection.classList.toggle('active');
});

//pour la carousel

const track = document.querySelector('.carousel-track');
const slides = document.querySelectorAll('.carousel-slide');
const prevBtn = document.querySelector('.prev-arrow');
const nextBtn = document.querySelector('.next-arrow');
let currentIndex = 0;

function updateSlidePosition() {
    track.style.transform = `translateX(-${currentIndex * 100}%)`;
}

nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % slides.length;
    updateSlidePosition();
});

prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    updateSlidePosition();
});

// Option: Ajouter le défilement automatique
setInterval(() => {
   currentIndex = (currentIndex + 1) % slides.length;
   updateSlidePosition();}, 5000);

//Script de la page Map

// Initialisation de la carte
const map = L.map('map').setView([9.9456, -9.6966], 6); // Centré sur la Guinée

// Ajout du fond de carte
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Coordonnées approximatives de la Guinée (polygone simplifié)
const guineaCoordinates = [
    [12.676, -15.127],
    [12.358, -14.426],
    [11.297, -14.349],
    [10.966, -12.179],
    [9.305, -13.123],
    [8.797, -8.313],
    [10.133, -8.033],
    [10.891, -8.563],
    [12.175, -13.109]
];

// Dessin de la Guinée
L.polygon(guineaCoordinates, {
    color: '#27ae60',
    weight: 2,
    fillColor: '#2ecc71',
    fillOpacity: 0.2
}).addTo(map).bindPopup('<b>République de Guinée</b>');

// Villes principales
const cities = [
    {
        name: "Conakry (Capitale)",
        coords: [9.6412, -13.5784],
        population: "1.6 million"
    },
    {
        name: "Nzérékoré",
        coords: [7.7548, -8.8179],
        population: "195,330"
    },
    {
        name: "Kankan",
        coords: [10.3845, -9.3057],
        population: "193,830"
    },
    {
        name: "Kindia",
        coords: [10.0600, -12.8658],
        population: "181,126"
    }
];

// Ajout des marqueurs pour les villes
cities.forEach(city => {
    L.marker(city.coords, {
        icon: L.divIcon({
            className: 'custom-marker',
            iconSize: [25, 25]
        })
    })
    .addTo(map)
    .bindPopup(`
        <b>${city.name}</b><br>
        Population: ${city.population}
    `);
});

// Ajout d'une légende
const legend = L.control({ position: 'bottomright' });
legend.onAdd = () => {
    const div = L.DomUtil.create('div', 'legend');
    div.innerHTML = `
        <h4>Légende</h4>
        <div style="background-color:#2ecc71; opacity:0.2; width:20px; height:20px; display:inline-block;"></div> Zone Guinée<br>
        <div class="custom-marker" style="display:inline-block;"></div> Ville
    `;
    return div;
};
legend.addTo(map);

//Script tabs
 // Gestion des tabs
 const tabs = document.querySelectorAll('.tab');
 tabs.forEach(tab => {
     tab.addEventListener('click', () => {
         tabs.forEach(t => t.classList.remove('active'));
         tab.classList.add('active');
     });
 });