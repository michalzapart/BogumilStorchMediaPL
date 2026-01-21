let donejty = [];

async function loadDonejty() {
    const response = await fetch('donejty.json');
    donejty = await response.json();
    loop(true);
}

// lista najmocniejszych słów (rozszerzona o wszystkie kontrowersyjne/wulgarne słowa z tekstów)
const strongWords = [
    "kurwa", "chuj", "jeb", "wypierdalać", "cwel", "ruchał", "zesrałeś", "zdechł", "skurwysyn",
    "pedofil", "nitro", "narkoman", "knur", "knura", "major", "prawda", "bije", "ukradłeś",
    "lateksie", "Konon", "bębnie", "ruchać", "skurwysynu", "cwelu", "chuja", "kurwy", "jebać",
    "siurek", "siurka", "siurku", "gówno", "pedał", "menel", "alkoholik", "ubek", "konfident",
    "oszust", "dupa", "tłusta", "jebnij", "gimbusy", "knurze", "jajcaty", "gruby", "ubeku",
    "lateks", "cwelobscy", "oszustka", "konfident", "menelice", "skurwysynu", "pierdol", "jebać",
    "zdechł", "zesrałeś", "tłusta", "dupa", "gównem", "paczki z gównem", "nitro", "narkomanie",
    "pedofile", "ruchać", "bijesz", "kradniesz", "lateksie", "lateksy", "knur", "cwel", "skurwysyn"
];

function randomDelay() {
    return 4000 + Math.random() * 4000; // 4–8s losowo
}

// zamienia mocne słowa na span z klasą
function highlightStrongWords(text) {
    let re = new RegExp(`\\b(${strongWords.join("|")})\\b`, "gi");
    return text.replace(re, '<span class="strong">$1</span>');
}

function showRandom(first = false) {
    if (donejty.length === 0) return;

    const el = document.getElementById('tresc');

    let i = Math.floor(Math.random() * donejty.length);
    const tekst = donejty[i]["Treść"];

    el.style.opacity = 0; // fade out

    setTimeout(() => {
        // opcjonalnie: mocne słowa zostają dłużej
        const isStrong = strongWords.some(word => tekst.toLowerCase().includes(word));
        const delayExtra = isStrong ? 2500 : 0;

        el.innerHTML = ""; // reset
        setTimeout(() => {
            el.innerHTML = highlightStrongWords(tekst); // tylko mocne słowa na czerwono
            el.style.opacity = 1; // fade in
        }, 1300 + delayExtra);
    }, 800);
}

function loop(first = false) {
    showRandom(first);
    setTimeout(() => loop(), randomDelay());
}

loadDonejty();
