- homepage host
  - infos : réservations en attente de validation
- homepage guest
   - réservations
   - actions : chercher repas
    ---

- mails d'alerte
- pages profil

- Service d'expiration des demandes de réservation
- Service de calcul du prix d'un repas.
- système de paiement

# Bugs
- contrainte d'unicité UniqueEntity(fields={"meal", "guest"}) ne fonctionne pas dans class Reservation
