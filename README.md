## Routeur statique et dynamique

Le routeur peut être statique ou dynamique celon votre usage, pour cela dans le '.env' completer la variable [ROUTER_AUTO] par true ou false.

### Routeur Dynamique ou Automatique:

Dans le cas de true le routeur récupéreras automatiquement l'url courrante et apelleras le controller associer a la route.

exemple : "http://enigma.fr" l'url appeleras le fichier [src/controller/Homecontroller.php] ou [src/controller/Indexcontroller.php] celon si votre fichier de référence est index ou home dans le fichier .env [DEFAULT] 'home' ou 'index'.

Par default dans le routeur dynamique l'url de la Homepage seras:
/ && /home pour [DEFAULT=home] || / && /index pour [DEFAULT=index].

### Routeur statique ou déclaratif:

Dans le cas de false vous devrais déclarer les route dans le fichier [Routes/web.php].

[PATH] = /url
[CONTROLER@function] = nomducontroller@nomdelafunction
[Mehod] = POST,GET,PUT,PATCH,DELETE

exemple:
$invok->Route('/','HomeController@view', 'GET');

l'url courante seras [/] le controller apeller seras [HomeController] et la function apeller seras [view].

## Database

1. Pour initialiser la base de donner commencer part remplire les champs demander dans le .env [DB_HOST],[DB_NAME],[DB_USERNAME], [DB_PASSWORD],[DB_PORT].

2. Executer la commande [php src/model/Database.php].

3)Executer la commande [php src/model/Method.php] pour créer la table Enigma.

4)Executer la commande [php Enigma/MakeEntity.php] pour commencer a créé une entité.

## Entity

Pour créé une entité la commande [php Enigma/MakeEntity.php] créé un questionnaire question reponse dans le terminal qui définira:
-Nom de la table,
-Le nom de la collone,
-le type de la collone,
-la valeur (si string) de la collone,
-Si la col peut être null,
-Si la col peut etre unique,

Une fois fini cela généreras un fichier du nom de la table dans [src/Entity/], dans ce fichier il y auras tout les setter et getter lier a cette table et des methods magique pour itéragir a la base de donnée.

Dans le controller l'instanciation de classe permettras de récupérer les setter et guetter de la base l'entity et donc pouvoir géré beaucoup de cas sans avoir a faire de sql dans le controller directement.

elle généreras aussi un formulaire qui auras le nom de la table+fom.
