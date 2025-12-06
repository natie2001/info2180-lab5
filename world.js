window.onload = function () {
    const button = document.getElementById("lookup");
    const input = document.getElementById("country");
    const resultDiv = document.getElementById("result");

    button.addEventListener("click", function () {
        const country = input.value.trim();

        
        const url = "world.php?country=" + encodeURIComponent(country);

       
        fetch(url)
            .then(response => response.text())   
            .then(data => {
                resultDiv.innerHTML = data;     
            })
            .catch(error => {
                resultDiv.innerHTML = "<p>Error loading data.</p>";
                console.error("AJAX Error:", error);
            });
    });
};
