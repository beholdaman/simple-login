### Consegna ###


Esercizio: registrazione e login in PHP + Bootstrap

Realizza una piccola applicazione web con registrazione utenti, login e un’area riservata. Usa PHP senza framework, MySQL e Bootstrap.

Requisiti obbligatori

Pagina di registrazione con nome, email, password e conferma password. Validazione sia lato client (con gli stili di Bootstrap) sia lato server: email valida e non già registrata, password di almeno 8 caratteri, le due password devono coincidere.
Pagina di login con email e password.
Area riservata accessibile solo agli utenti autenticati, con un messaggio di benvenuto e il pulsante di logout. Se un utente non loggato prova ad accedervi, va rimandato al login.
Messaggi di errore e di successo chiari, mostrati con i componenti Bootstrap, mantenendo i campi già compilati in caso di errore (tranne le password).
Layout responsive, utilizzabile anche da smartphone.
Uno script SQL per creare il database.

Requisiti di sicurezza

Le password vanno salvate in modo sicuro, le query devono essere protette dalla SQL injection.
Gestisci la sessione in modo sicuro dopo il login.

Blocco temporaneo dopo 5 tentativi di login falliti, opzione “ricordami”, recupero password.

Repository GitHub o simile, con un README che spieghi come avviare il progetto e le principali scelte fatte.




### Dryrun ###

- Eseguire script SQL
- Modificare le costanti in `conf/conf.php` con il prorpio nome utente e password mysql
- Caricare la pagina `login.php`

### Scelte progettuali ### 

- Email e password salvate nei cookie per permanenza login in sessioni diverse
- Email e password salvate in `$_SESSION` per validazione in eventuali pagine future
- Timeout salvato in `$_SESSION` per evitare che venga aggirato ricaricando la pagina