
### Dryrun ###

- Eseguire script SQL
- Modificare le costanti in `conf/conf.php` con il prorpio nome utente e password mysql
- Caricare la pagina `login.php`

### Scelte progettuali ### 

- Email e password salvate nei cookie per permanenza login in sessioni diverse
- Email e password salvate in `$_SESSION` per validazione in eventuali pagine future
- Timeout salvato in `$_SESSION` per venga aggirato ricaricando la pagina