window.onload = function () {
    const lookupBtn = document.getElementById("lookup");
    const lookupCitiesBtn = document.getElementById("lookup-cities");
    const input = document.getElementById("country");
    const resultDiv = document.getElementById("result");

    // Lookup Country
    lookupBtn.addEventListener("click", function () {
        const country = input.value.trim();
        fetch("world.php?country=" + encodeURIComponent(country))
            .then(res => res.text())
            .then(data => { resultDiv.innerHTML = data; })
            .catch(err => {
                resultDiv.innerHTML = "<p>Error loading data.</p>";
                console.error(err);
            });
    });

    // Lookup Cities
    lookupCitiesBtn.addEventListener("click", function () {
        const country = input.value.trim();
        fetch("world.php?country=" + encodeURIComponent(country) + "&lookup=cities")
            .then(res => res.text())
            .then(data => { resultDiv.innerHTML = data; })
            .catch(err => {
                resultDiv.innerHTML = "<p>Error loading data.</p>";
                console.error(err);
            });
    });
};
