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


function main(withIP = true)
{
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
                .then(json => json)

        displayWeatherInfos(meteo);
    }

    if (withIP)
    {
        var options = {
            enableHighAccuracy: true,
            maximumAge: 0
        };

        function success(pos) {
            var crd = pos.coords;
            getMeteo(crd);

        };

        function error(err) {
            console.warn(`ERROR(${err.code}): ${err.message}`);
        };
        navigator.geolocation.getCurrentPosition(success, error, options);

    } else {
        getMeteo();
    }

}

function displayWeatherInfos(data)
{
    if(data.main !== undefined)
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

}

const ville = document.getElementById("ville");

ville.addEventListener('click', () => {
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
