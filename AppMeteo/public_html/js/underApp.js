const weatherClass = document.querySelectorAll(".weather");
weatherClass.contentEditable = false;

function capitalize(str)
{
    return str[0].toUpperCase() + str.slice(1);
}

/* global fetch */


function main(withIP = true) {

    /* Requête OpenWeatherMap */

    async function getMeteo(crd)
    {
        let req;

        if (crd)
        {
            req = `https://api.openweathermap.org/data/2.5/weather?lat=${crd.latitude}&lon=${crd.longitude}&appid=f1286dc7f273ee264e8c0026fc15c313&lang=fr&units=metric`;

        } else {
            let ville = document.getElementById("ville").value;

            req = `https://api.openweathermap.org/data/2.5/weather?q=${ville}&appid=f1286dc7f273ee264e8c0026fc15c313&lang=fr&units=metric`;
        }
        const meteo = await fetch(req)

            .then(resultat => resultat.json())
            .then(json => json);

        displayWeatherInfos(meteo);
    }

    /* Récupèration de la position du client */

    if (withIP) {
        function success(pos) {
            let crd = pos.coords;
            getMeteo(crd);
        }
        navigator.geolocation.getCurrentPosition(success);
    } else {
        getMeteo();
    }
}
const warning = document.getElementById("warning_text");

function displayWeatherInfos(data)
{
    if(data.cod === "404")
    {

        warning.textContent = "La ville saisie est incorrect";
        warning.style.opacity = 1;

    } else if(warning) {
        const name = data.name;
        const temperature = data.main.temp;
        const conditions = data.weather[0].main;
        const description = data.weather[0].description;

        document.getElementById("ville").value = name;
        document.getElementById("temperature").value = Math.round(temperature);
        document.getElementById("conditions").value = capitalize(description);

        document.body.className = conditions.toLowerCase();

        document.getElementById("warning_text").textContent = "Statement";
        document.getElementById("warning_text").style.opacity = 0;
    } else {
        document.body.className = data.weather[0].main.toLowerCase();
    }
}

const ville = document.getElementById("ville");

if(ville)
{
    /* Enlève l'usage par défaut de "entrée" */
    ville.addEventListener('click', () => {
        ville.contentEditable = true;
    });

    ville.addEventListener('keydown', (e) => {
        if (e.keyCode === 13) {
            e.preventDefault();
            main(false);
        }
    });
}

    /* Auto-complétion */

let options = {
    types: ['geocode']
};

function activatePlacesSearch()
{
    let input = document.getElementById("ville");
    let autocomplete = new google.maps.places.Autocomplete(input, options);
}

    /* Appel main */

main();

