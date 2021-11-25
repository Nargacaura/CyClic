# Cahier des charges

- Un utilisateur s'inscrit (il indique notamment tous les lieux où il se rend disponible)
  - S'il souhaite pouvoir effectuer des emprunts, il verse une caution unique
- Un utilisateur publie une annonce soit de prêt, soit de don
L'annonce contient les catégories de l'objet, la photo, le descriptif, le statut (prêt/don), la durée du prêt (en cas de prêt)
- Un visiteur navigue sur le site pour voir les annonces (via menus, barre de recherche, système de filtre (modification lieu possible par ce biais)...) Il voit les annonces en fonction de son lieu principal.
  - **Nécessité d'être inscrit pour emprunter/recevoir**
- Une personne inscrite peut signaler son intérêt pour l'annonce par un message
- la personne qui a publié l'annonce est notifié du message
- elle valide le don/prêt et communique avec la personne intéressée pour fixer un rdv
  - en cas de don, l'offre est supprimée sur l'affichage du site
  - en cas de prêt, l'offre est rendue indisponible
    - en cas de prêt, les deux parties reçoivent à l'avance une notification à l'approche de la date de fin du prêt
      - en cas de respect des délais, le prêteur valide la restitution du prêt et le site propose au prêteur de remettre l'offre en disponibilité, le prêteur et l'emprunteur sont invités à se noter mutuellement. 
      - en cas de retard, l'emprunteur et le prêteur reçoivent une notification de retard. Les deux parties sont invitées à communiquer
        - l'emprunteur peut demander un délai supplémentaire, le prêteur valide ou refuse le délai
      - en cas de situation de retard, le prêteur effectue un signalement qui lance un décompte, si l'objet est toujours en retard à la fin du compte ( un mois par exemple), le compte de l'emprunteur est suspendu et la caution est versée au prêteur
      - En cas de problème, un utilisateur (prêteur ou emprunteur) peut envoyer un message à l'administrateur du site
- À n'importe quel moment, un utilisateur qui n'a pas d'emprunts en cours peut reprendre sa caution (mais à ce moment-là il ne peut pas faire de nouveaux emprunts, à moins de verser à nouveau une caution).
- Un utilisateur peut avoir seulement un certain nombre (exemple : 3) d'objets empruntés simultanément
- système d'alerte : un utilisateur met en place une alerte sur un objet attendu et spécifié comme il veut. A chaque publication d'une nouvelle annonce, on vérifie si l'annonce correspond à l'alerte, si c'est le cas il est notifié avec un lien vers l'annonce.S
- notifications : envois d'emails par défaut à l'utilisateur

_**À signaler que le site est destiné à l'échange ou au don d'objets de valeur faible et décline toute responsabilité en cas d'échange qui ne respecte pas cette charte.**_