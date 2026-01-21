let donejty = [];

async function loadDonejty() {
    const response = await fetch('donejty.json');
    donejty = await response.json();
    loop(true);
}

function randomDelay() {
    return 4000 + Math.random() * 4000; // losowe 4–8s
}

function showRandom(first = false) {
    if (donejty.length === 0) return;

    const el = document.getElementById('tresc');

    let i = Math.floor(Math.random() * donejty.length);
    const tekst = donejty[i]["Treść"];

    // fade out
    el.style.opacity = 0;

    setTimeout(() => {
        // sprawdź czy jest przekleństwo
        const cursedWords = ["kurwa","chuj","pierdol","jeb"];
        const delayExtra = cursedWords.some(w => tekst.toLowerCase().includes(w)) ? 2500 : 0;

        el.textContent = "";
        setTimeout(() => {
            el.textContent = tekst;
            el.style.opacity = 1;
        }, 1300 + delayExtra);

    }, 800);
}

function loop(first = false) {
    showRandom(first);
    setTimeout(() => loop(), randomDelay());
}

loadDonejty();
