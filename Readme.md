<div align="center">

![CyClic](public_html/img/wordmark.png)

&copy; 2021-2022 Les Symfonistes Croustillants

</div>

---

<div align="center">

# Qu'est-ce que CyClic?

</div>

CyClic est **un site d'échange/de don d'objets** qui a été créé durant la formation de CDA PHP orienté objet de la [Chambre de Commerce et d'Industrie](https://ccicampus.fr) en tant que projet principal de celle-ci, aux côtés des sites [d'un camping](https://dev.azure.com/CCICampus/CampingSavoie) et [d'un club de football](https://dev.azure.com/CCICampus/FCRosheim), réalisés par les deux autres groupes de la promotion 2021-2022. *Allez y jeter un coup d'oeil là-bas aussi, ils en valent aussi le coup.*

<div align="center">

# À quoi ça ressemble?

</div>

Les maquettes de CyClic sont mises à disposition dans la branche **documentation**. Mais il y a des chances que cela ne représentera pas le produit final, car ce ne sont que des prototypes d'interface utilisateur. *Et vous aurez remarqué qu'on a des visions différentes de son apparence.* Mais, une fois le site hébergé, on vous refilera le lien. Tant qu'à faire, on a aussi mis les [logos](Logos) histoire de voir les propositions effectuées avant de se tourner sur celui-ci.

<div align="center">

# Où sont les docs?

</div>

Les docs sont disponibles dans la branche **documentation**, tout comme les maquettes de CyClic.

<div align="center">

# Et à quoi sert ce repo Git?

</div>

Ce répo sert de **backup au projet disponible sur [Azure DevOps](https://dev.azure.com/CCICampus/CroustiRecycle)**, au cas où quelque chose irait mal là-bas. *Mouais, on n'aime pas trop le Git flow.*

<div align="center">

# Mais qui sont ces "Symfonistes Croustillants"?

</div>

Les **Symfonistes Croustillants** font référence à [Symfony](https://symfony.com), le framework utilisé pour ce projet, et aux Croustillants (et les Semi-croustillants, faut pas les oublier) de *Kaamelott*, série qu'on aime bien (au moins, on a un truc en commun, mise à part le fait d'être dans la même formation pour ce projet). *Parce que oui, on a des goûts différents. __Très__ différents.*

Les membres de ce groupe sont:
- **[DUCHESNE Florian](https://github.com/FlorianDuchesne)**,
- **[LANDAUER Mathieu](https://github.com/matiland)**,
- **[LEDDA Damien](https://github.com/Nargacaura)**,
- **[MOUGENOT Antonin](https://github.com/sStratioSs)**,
- **[SCHAEFFER Léonard](https://github.com/Sielfyr)**.

Mais si voulez plus de précisions sur chacun d'entre nous, faudra voir s'ils sont d'accord pour s'introduire un peu ici ou dans la doc utilisateur.

<div align="center">

# Comment le faire fonctionner?

</div>

Pour le faire fonctionner, vous aurez besoin de:
- **[Symfony](https://symfony.com)**,
- **[Composer](https://getcomposer.org)**,
- **[PHP](https://php.net)** (&ge; 7.4),
- **[Node.js](https://nodejs.org)**,
- **[Yarn](https://yarnpkg.org)**.

> :pencil2: Une mise à jour vers PHP 8.1 sera effectuée sous peu, au vu de l'expiration de la version 7.4 en novembre 2022.

Une fois ces pré-requis installés, lancez dans l'ordre:
- **`composer i`** pour installer les dépendances Composer,
- **`npm install`** pour ajouter les dépendances NPM,
- **`npm run dev`** pour compiler les styles SCSS et les scripts JS,
- **`symfony console d:d:c`** pour créer la base de données si elle n'est pas encore présente dans votre collection de bases,
- **`symfony console m:mi; symfony console d:m:m`** pour exécuter les migrations,
- **`symfony console d:f:l`** pour charger les fixtures,
- **`symfony server:start`** ou **`symfony:serve`** pour lancer le serveur.

> :pencil2: Si `symfony console d:m:m` ne fonctionne pas, remplacez-le par `symfony console d:s:u --force`.

> :warning: N'oubliez pas de copier le .env et de **renommer la copie en .env.local** et de modifier le SGBDR afin d'utiliser le bon et de mettre comme nom de BdD "**CyClic**"!

<div align="center">

# Uhh... is there an english version of this?

</div>

Not yet, but we'll be working on it, as it may be required in a moment or another. We'll let you know when CyClic's available in that language, so don't worry about this.
