# Quadri #
----------

## Template ##

Per creare un template dove inserire il testo e le etichette di "pagamenti", "contatti", ecc, usa il link
 [/text.php](http://federicopirani.com/Quadri/text.php); per modificare un template esistente 
 invece [/text.php?fname=default](http://federicopirani.com/Quadri/text.php?fname=default) dove `default` è il nome del file.

Se non vuoi una sezione basta lasciare l'etichetta e il contenuto vuoti.

Una volta inseriti tutti i dati clicca su `carica`.

## Creare una pagina ##

Per creare una pagina vai su [/makeme.php](http://federicopirani.com/Quadri/makeme.php).

Inserire il titolo, l'autore, le dimensioni (che comunque se sono vuoti non vengono visualizzate).

Se vuoi usare un'immagine più piccola come preview lascia `Crea immagine` col check. 
Questo lo rende un po' più noioso perchè poi devi caricare i file sul server ma almeno dovrebbe funzionare sempre,
 senza il check funziona raramente.

Se vuoi l'immagine 3d col telaio lascia `Usa 3D` col check.

Alla fine scegli il template fra quelli disponibili (se non l'hai ancora caricato, non ti farà vedere niente) e clicca `Crea`.

## Salvare una pagina ##

In fondo all pagina creata c'è un link `File zip`. Scarica lo zip che dovrebbe contenere tre file: due 
immagini (se non hai messo il check a `Crea immagine` non ci saranno) e un file di testo.

Il file di testo contiene l'html da mettere su ebay, le immagini invece devi caricarle sul tuo server in `/paintings/ebay/`.

Se crei un'altra pagina nel frattempo lo zip precedente non sarà più disponibile.

## Installazione ##

Se proprio vuoi installarlo ti servirà Apache (probabilmente funziona con qualsiasi webserver), PHP e
 [Composer](https://getcomposer.org/doc/00-intro.md#installation-windows).
 
 Scarica questo zip, lo metti nella directory che vuoi del server, scarica [composer.phar](http://getcomposer.org/composer.phar)
  nella directory principale `Quadri` e dalla cartella esegui `php composer.phar install`.
  
 Fatto.
