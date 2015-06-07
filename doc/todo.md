- homepage host
  - infos : réservations en attente de validation
- homepage guest
   - réservations
   - actions : chercher repas
    ---

- mails d'alerte
- pages profil

# Bugs
- contrainte d'unicité UniqueEntity(fields={"meal", "guest"}) ne fonctionne pas dans class Reservation
