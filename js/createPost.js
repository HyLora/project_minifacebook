function toggleFields() {
    var Tipo = document.querySelector('select[name="Tipo"]').value;
    var Descrizione = document.getElementById('Descrizione');
    var Contenuto = document.getElementById('Contenuto');
    var Immagine = document.getElementById('Immagine');
    var Geo = document.getElementById('Geo');

    if (Tipo === 'foto') {
        Descrizione.style.display = 'block';
        Contenuto.style.display = 'none';
        Immagine.style.display = 'block';
        Geo.style.display = 'block';
    } else if (Tipo === 'testo') {
        Descrizione.style.display = 'none';
        Contenuto.style.display = 'block';
        Immagine.style.display = 'none';
        Geo.style.display = 'none';
    } else if (Tipo === '') {
        Descrizione.style.display = 'none';
        Contenuto.style.display = 'none';
        Immagine.style.display = 'none';
        Geo.style.display = 'none';
    }  
}