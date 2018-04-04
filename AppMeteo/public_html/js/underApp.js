function main(withIP = true) {
    /* Requête OpenWeatherMap */

    async function getMeteo(crd) {
        let req;

        if (crd) {
            req = `https://api.openweathermap.org/data/2.5/weather?lat=${crd.latitude}&lon=${crd.longitude}&appid=f1286dc7f273ee264e8c0026fc15c313&lang=fr&units=metric`;

        }

        const meteo = await fetch(req)

            .then(resultat => resultat.json())
            .then(json => json);

        displayWeatherInfos(meteo);
    }

    /* Récupèration de la position du client */

    if (withIP) {
        function success(pos) {
            var crd = pos.coords;
            getMeteo(crd);
        };

        navigator.geolocation.getCurrentPosition(success);

    }

}


function displayWeatherInfos(data)
{
        const conditions = data.weather[0].main;
        document.body.className = conditions.toLowerCase();
}

main();