<div style="text-align:center; font-family: 'Outfit', 'Segoe UI', sans-serif;">
<!-- <span style="color:#1844ed;font-size:150px; font-family: 'Cy', 'Franklin Gothic', sans-serif; text-align:center;">Cy<span style="color:#ee7c01; font-family: 'Outfit';">Clic</span></span> -->

![Logo CyClic](public_html/img/wordmark.png)

&copy; 2021-2022 Les Symfonistes Croustillants

</div>

---
<div style="font-family: 'Outfit', 'Segoe UI', sans-serif;">

<h1 style="color:#1844ed; font-weight: bold; font-size:48px; font-family: 'Cy', 'Franklin Gothic', sans-serif; text-align:center;">Qu'est-ce que Cy<span style="color:#ee7c01; font-family: 'Outfit';">Clic</span>?</h1>

<span style="color:#1844ed; font-family:'Cy';">Cy</span><span style="color:#ee7c01">Clic</span> est **un site d'échange/de don d'objets** qui a été créé durant la formation de CDA PHP orienté objet de la <a href="https://ccicampus.fr" style="color: #ee7c01; text-decoration: none;">Chambre de Commerce et d'Industrie</a> en tant que projet principal de celle-ci, aux côtés des sites <a href="https://dev.azure.com/CCICampus/CampingSavoie" style="color: #ee7c01; text-decoration: none;">d'un camping</a> et <a href="https://dev.azure.com/CCICampus/FCRosheim" style="color: #ee7c01; text-decoration: none;">d'un club de football</a>, réalisés par les deux autres groupes de la promotion 2021-2022. *Allez y jeter un coup d'oeil là-bas aussi, ils en valent aussi le coup.*

<h1 style="color:#1844ed; font-weight: bold; font-size:48px; font-family: 'Cy', 'Franklin Gothic', sans-serif; text-align:center;">À quoi ça ressemble?</h1>

Les maquettes de <span style="color:#1844ed; font-family:'Cy';">Cy</span><span style="color:#ee7c01">Clic</span> sont mises à disposition **sur le GitHub (privé pour l'instant) du projet**. Mais il y a des chances que cela ne représentera pas le produit final, car ce ne sont que des prototypes d'interface utilisateur. *Et vous aurez remarqué qu'on a des visions différentes de son apparence.* Mais, une fois le site hébergé, on vous refilera le lien.

<h1 style="color:#1844ed; font-weight: bold; font-size:48px; font-family: 'Cy', 'Franklin Gothic', sans-serif; text-align:center;">Où sont les docs?</h1>

Les docs seront bientôt disponibles dans **le répo GitHub du projet** (eh oui, eux aussi). On mettra à disposition les docs technique et utilisateur quand ils seront terminés et convertis en PDF.

<h1 style="color:#1844ed; font-weight: bold; font-size:48px; font-family: 'Cy', 'Franklin Gothic', sans-serif; text-align:center;">Y a-t-il un backup de ce répo Azure?</h1>

On a un backup de ce projet Azure **disponible sur <a href="https://github.com/Nargacaura/CyClic" style="color: #ee7c01; text-decoration: none;">GitHub</a>** (privé pour l'instant, mais sera rendu public au mois de mars ou plus tôt si tout le monde est d'accord), au cas où quelque chose irait mal là-bas. *Mouais, on n'aime pas trop le Git flow.*

<h1 style="color:#1844ed; font-weight: bold; font-size:48px; font-family: 'Cy', 'Franklin Gothic', sans-serif; text-align:center;">Mais qui sont ces "Symfonistes Croustillants"?</h1>

Les **Symfonistes Croustillants** font référence à <a href="https://symfony.com" style="color: #ee7c01; text-decoration: none;">Symfony</a>, le framework utilisé pour ce projet, et aux Croustillants (et les Semi-croustillants, faut pas les oublier) de *Kaamelott*, série qu'on aime bien (au moins, on a un truc en commun, mise à part le fait d'être dans la même formation pour ce projet). *Parce que oui, on a des goûts différents. __Très__ différents.*

Les membres de ce groupe sont:
- **<a href="https://github.com/FlorianDuchesne" style="color: #ee7c01; text-decoration: none;">DUCHESNE Florian</a>**,
- **<a href="https://github.com/matiland" style="color: #ee7c01; text-decoration: none;">LANDAUER Mathieu</a>**,
- **<a href="https://github.com/Nargacaura" style="color: #ee7c01; text-decoration: none;">LEDDA Damien</a>**,
- **<a href="https://github.com/sStratioSs" style="color: #ee7c01; text-decoration: none;">MOUGENOT Antonin</a>**,
- **<a href="https://github.com/Sielfyr" style="color: #ee7c01; text-decoration: none;">SCHAEFFER Léonard</a>**.

Mais si voulez plus de précisions sur chacun d'entre nous, faudra voir s'ils sont d'accord pour s'introduire un peu ici ou dans la doc utilisateur.

<h1 style="color:#1844ed; font-weight: bold; font-size:48px; font-family: 'Cy', 'Franklin Gothic', sans-serif; text-align:center;">Comment le faire fonctionner?</h1>

Pour le faire fonctionner, vous aurez besoin de:
- **<a href="https://symfony.com" style="color: #ee7c01; text-decoration: none;">Symfony</a>**,
- **<a href="https://getcomposer.org" style="color: #ee7c01; text-decoration: none;">Composer</a>**,
- **<a href="https://php.net" style="color: #ee7c01; text-decoration: none;">PHP</a>** (&ge; 7.4),
- **<a href="https://nodejs.org" style="color: #ee7c01; text-decoration: none;">Node.js</a>**,
- **<a href="https://yarnpkg.org" style="color: #ee7c01; text-decoration: none;">Yarn</a>**.

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

<h1 style="color:#1844ed; font-weight: bold; font-size:48px; font-family: 'Cy', 'Franklin Gothic', sans-serif; text-align:center;">Uhh... is there an english version of this?</h1>

Not yet, but we'll be working on it, as it may be required in a moment or another. We'll let you know when <span style="color:#1844ed; font-family:'Cy';">Cy</span><span style="color:#ee7c01">Clic</span>'s available in that language, so don't worry about this.

</div>