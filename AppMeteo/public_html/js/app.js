const weatherIcons = {
    "Rain": "wi wi-day-rain",
    "Clouds": "wi wi-day-cloudy",
    "Clear": "wi wi-day-sunny",
    "Snow": "wi wi-day-snow",
    "mist": "wi wi-day-fog",
    "Drizzle": "wi wi-day-sleet"

};

function capitalize(str)
{
    return str[0].toUpperCase() + str.slice(1);
}

/* global fetch */

async function main(withIP = true)
{
    let ville;
    
    if (withIP)
    {
        const ip = await fetch('https://api.ipify.org?format=json')
                .then(resultat => resultat.json())
                .then(json => json.ip);


         ville = await fetch('http://freegeoip.net/json/' + ip)
                .then(resultat => resultat.json())
                .then(json => json.city);
    } else {
        ville = document.getElementById("ville").textContent;
    }

    const meteo = await fetch('http://api.openweathermap.org/data/2.5/weather?q=' + ville + '&APPID=f1286dc7f273ee264e8c0026fc15c313&lang=fr&units=metric')
            .then(resultat => resultat.json())
            .then(json => json);

    displayWeatherInfos(meteo);
} 

function displayWeatherInfos(data)
{
    const name = data.name;
    const temperature = data.main.temp;
    const conditions = data.weather[0].main;
    const description = data.weather[0].description;

    document.getElementById("ville").textContent = name;
    document.getElementById("temperature").textContent = Math.round(temperature);
    document.getElementById("conditions").textContent = capitalize(description);

    document.querySelector('i.wi').className = weatherIcons[conditions];

    document.body.className = conditions.toLowerCase();
}

const ville = document.getElementById("ville");

ville.addEventListener('click', () =>  {
    ville.contentEditable = true;
});

ville.addEventListener('keydown', (e) => {
    if (e.keyCode === 13) {
        e.preventDefault();
        ville.contentEditable = false;
        main(false); 
    }
});

main();