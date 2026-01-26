let donejty = [];
let index = 0; // licznik do iterowania po donejtach

async function loadDonejty() {
    const response = await fetch('../data/donejty.json');
    donejty = await response.json();
    loop(); // start
}

const strongWords = [
    "kurwa", "chuj", "jeb", "wypierdalać", "cwel", "ruchał", "zesrałeś", "zdechł", "skurwysyn",
    "pedofil", "nitro", "narkoman", "knur", "knura", "major", "prawda", "bije", "ukradłeś",
    "lateksie", "Konon", "bębnie", "ruchać", "skurwysynu", "cwelu", "chuja", "kurwy", "jebać",
    "siurek", "siurka", "siurku", "gówno", "pedał", "menel", "alkoholik", "ubek", "konfident",
    "oszust", "dupa", "tłusta", "jebnij", "gimbusy", "knurze", "jajcaty", "gruby", "ubeku",
    "lateks", "cwelobscy", "oszustka", "konfident", "menelice", "skurwysynu", "pierdol", "jebać",
    "zdechł", "zesrałeś", "tłusta", "dupa", "gównem", "paczki z gównem", "nitro", "narkomanie",
    "pedofile", "ruchać", "bijesz", "kradniesz", "lateksie", "lateksy", "knur", "cwel", "skurwysyn",
    "mordowania", "mordowanie", "żyd", "Żydów", "rozjebać", "jebać", "pedałowi", "cwelem", "cwel",
    "Majora", "Major", "Wojtek", "Konon", "pedały", "pedałowi", "cichodajka", "cwele", "umarł", "rucham", "wpierdolimy", "wiedźma"
];

function highlightStrongWords(text) {
    let re = new RegExp(`\\b(${strongWords.join("|")})\\b`, "gi");
    return text.replace(re, '<span class="strong">$1</span>');
}

function showNext() {
    if (donejty.length === 0) return;

    const el = document.getElementById('quote-text');
    const tekst = donejty[index]["Treść"];

    el.style.opacity = 0; // fade out

    setTimeout(() => {
        el.innerHTML = highlightStrongWords(tekst);
        el.style.opacity = 1; // fade in
    }, 500);

    // przechodzimy do następnego tekstu
    index++;
    if (index >= donejty.length) index = 0; // wracamy na początek
}

function loop() {
    showNext();
    setInterval(showNext, 5000); // co 5 sekund nowy tekst
}

loadDonejty();
