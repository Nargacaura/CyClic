![CyClic](Logos/Final/Colors%20-%2018edb1,%201844ed%20&%20ee7c01/CyClic_wordmark%20(1844ed%20&%20ee7c01).png)

&copy; 2021-2022 Les Symfonistes Croustillants

---

# Qu'est-ce que CyClic?

CyClic est **un site d'échange/de don d'objets** qui a été créé durant la formation de CDA PHP orienté objet de la [Chambre de Commerce et d'Industrie](https://ccicampus.fr) en tant que projet principal de celle-ci, aux côtés des sites [d'un camping](https://dev.azure.com/CCICampus/CampingSavoie) et [d'un club de football](https://dev.azure.com/CCICampus/FCRosheim), réalisés par les deux autres groupes de la promotion 2021-2022. *Allez y jeter un coup d'oeil là-bas aussi, ils en valent aussi le coup.*

# À quoi ça ressemble?

Les maquettes de CyClic sont mises à disposition **[ici](Maquettes)**. Mais il y a des chances que cela ne représentera pas le produit final, car ce ne sont que des prototypes d'interface utilisateur. *Et vous aurez remarqué qu'on a des visions différentes de son apparence.* Mais, une fois le site hébergé, on vous refilera le lien. Tant qu'à faire, on a aussi mis les [logos](Logos) histoire de voir les propositions.

# Où sont les docs?

Les docs seront bientôt disponibles dans **[le dossier de docs](Documentation)**. On mettra à disposition les docs technique et utilisateur quand ils seront terminés et convertis en PDF.

# Et à quoi sert ce repo Git?

Ce Git servira de **backup au projet disponible sur [Azure DevOps](https://dev.azure.com/CCICampus/CroustiRecycle)**, au cas où quelque chose irait mal là-bas. *Mouais, on n'aime pas trop le Git flow.*

# Mais qui sont ces "Symfonistes Croustillants"?

Les **Symfonistes Croustillants** font référence à [Symfony](https://symfony.com), le framework utilisé pour ce projet, et aux Croustillants (et les Semi-croustillants, faut pas les oublier) de *Kaamelott*, série qu'on aime bien (au moins, on a un truc en commun, mise à part le fait d'être dans la même formation pour ce projet). *Parce que oui, on a des goûts différents. __Très__ différents.*

Les membres de ce groupe sont:
- **[DUCHESNE Florian](https://github.com/FlorianDuchesne)**,
- **[LANDAUER Mathieu](https://github.com/matiland)**,
- **[LEDDA Damien](https://github.com/Nargacaura)**,
- **[MOUGENOT Antonin](https://github.com/sStratioSs)**,
- **[SCHAEFFER Léonard](https://github.com/Sielfyr)**.

Mais si voulez plus de précisions sur chacun d'entre nous, faudra voir s'ils sont d'accord pour s'introduire un peu ici ou dans la doc utilisateur.

# Comment le faire fonctionner?

Pour le faire fonctionner, vous aurez besoin de:
- **[Symfony](https://symfony.com)**,
- **[Composer](https://getcomposer.org)**,
- **[PHP](https://php.net)** (&ge; 7.4),
- **[Node.js](https://nodejs.org)**,
- **[Yarn](https://yarnpkg.org)**.

Une fois ces pré-requis installés, lancez dans l'ordre:
- **`composer i`** pour installer les dépendances Composer,
- **`npm install`** pour ajouter les dépendances NPM,
- **`yarn install`** pour avoir celles de Yarn,
- **`yarn encore dev`** pour compiler les styles SCSS et les scripts JS,
- **`php bin/console d:d:c`** pour créer la base de données si elle n'est pas encore présente dans votre collection de bases,
- **`php bin/console m:mi; php bin/console d:m:m`** pour exécuter les migrations,
- **`php bin/console d:f:l`** pour charger les fixtures,
- **`symfony serve`** pour lancer le serveur.

> :pencil2: Si `php bin/console d:m:m` ne fonctionne pas, remplacez-le par `php bin/console d:s:u --force`.

# Uhh... is there an english version of this?

Not yet, but we'll be working on it, as it may be required in a moment or another. We'll let you know when CyClic's available in that language, so don't worry about this.
