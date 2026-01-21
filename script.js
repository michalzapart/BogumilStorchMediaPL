let donejty = [];

async function loadDonejty() {
    const response = await fetch('donejty.json');
    donejty = await response.json();
    showRandom(true); // pierwsze wejście bez fade-out
}

function showRandom(first = false) {
    if (donejty.length === 0) return;

    const el = document.getElementById('tresc');

    if (first) {
        const i = Math.floor(Math.random() * donejty.length);
        el.textContent = donejty[i]["Treść"];
        el.style.opacity = 1;
        return;
    }

    // fade out
    el.style.opacity = 0;

    setTimeout(() => {
        const i = Math.floor(Math.random() * donejty.length);
        el.textContent = donejty[i]["Treść"];

        // fade in
        el.style.opacity = 1;
    }, 600); // MUSI się zgadzać z CSS transition
}

loadDonejty();
setInterval(showRandom, 3000);