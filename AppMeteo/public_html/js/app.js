const weatherIcons = {
    "Rain": "wi wi-day-rain",
    "Clouds": "wi wi-day-cloudy",
    "Clear": "wi wi-day-sunny",
    "Snow": "wi wi-day-snow",
    "Mist": "wi wi-day-fog",
    "Drizzle": "wi wi-day-sleet",
    "Thunderstorm": "wi wi-day-thunderstorm"
};

const borderTemp = {
    "Rain": "1px solid black",
    "Clouds": "1px solid grey",
    "Clear": "1px solid yellow",
    "Snow": "1px solid white",
    "Mist": "1px solid grey",
    "Drizzle": "1px solid dimgray",
    "Thunderstorm": "1px solid white"
};

const boxTemp = {
    "Rain": "2px 2px 5px black",
    "Clouds": "2px 2px 5px grey",
    "Clear": "2px 2px 5px yellow",
    "Snow": "2px 2px 5px white",
    "Mist": "2px 2px 5px grey",
    "Drizzle": "2px 2px 5px dimgray",
    "Thunderstorm": "2px 2px 5px white"
};



function capitalize(str)
{
    return str[0].toUpperCase() + str.slice(1);
}

/* global fetch */


function main(withIP = true)
{
    /* Requête OpenWeatherMap */
    
    async function getMeteo(crd)
    {
        let req;
        
        if (crd)
        {
            req = `https://api.openweathermap.org/data/2.5/weather?lat=${crd.latitude}&lon=${crd.longitude}&appid=f1286dc7f273ee264e8c0026fc15c313&lang=fr&units=metric`;

        } else {
            let ville = document.getElementById("ville").textContent;

            req = `https://api.openweathermap.org/data/2.5/weather?q=${ville}&appid=f1286dc7f273ee264e8c0026fc15c313&lang=fr&units=metric`;
        }

            const meteo = await fetch(req)
          
                .then(resultat => resultat.json())
                .then(json => json);
            
        displayWeatherInfos(meteo);         
    }
   
    /* Récupèration de la position du client */

    if (withIP)
    {
        function success(pos) {
            var crd = pos.coords;
            getMeteo(crd);
        };
        
        navigator.geolocation.getCurrentPosition(success);

    } else {
           getMeteo();
    }

}

    /* Modifie le style en fonction des données passé */

function displayWeatherInfos(data)
{
    if(data.cod === "404")
    {
        document.getElementById("warning_text").textContent = "La ville saisie est incorrect";
        document.getElementById("warning_text").style.opacity = 1;
        
    } else {
        const name = data.name;
        const temperature = data.main.temp;
        const conditions = data.weather[0].main;
        const description = data.weather[0].description;

        document.getElementById("ville").textContent = name;
        document.getElementById("temperature").textContent = Math.round(temperature);
        document.getElementById("conditions").textContent = capitalize(description);

        document.querySelector('i.wi').className = weatherIcons[conditions];
        document.getElementById("ville").style.border = borderTemp[conditions];
        document.getElementById("ville").style.boxShadow = boxTemp[conditions];

        document.body.className = conditions.toLowerCase();
        
        document.getElementById("warning_text").textContent = "Statement";
        document.getElementById("warning_text").style.opacity = 0;
    }

}

    /* Rend l'élément "ville" modifiable */

const ville = document.getElementById("ville");

ville.addEventListener('click', () => {
    ville.contentEditable = true;
});

    /* Enlève l'usage par défaut de "entrée" */

ville.addEventListener('keydown', (e) => {
    if (e.keyCode === 13) {
        e.preventDefault();
        ville.contentEditable = false;
        main(false);
    }
});

    /* Appel main */

main();
