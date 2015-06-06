heroku config bdd : http://stfalcon.com/en/blog/post/deploying-symfony2-applications-on-heroku-cloud
- homepage host
  - actions : ajout repas
  - infos : réservations en attente de validation
- homepage guest
   - réservations
   - actions : chercher repas
   - ?
- dates en français
- form nouveau repas : restreindre nbre de convives de 1 à 10 => selectbox
- mails d'alerte
- pages profil

# Bugs
- contrainte d'unicité UniqueEntity(fields={"meal", "guest"}) ne fonctionne pas dans class Reservation
