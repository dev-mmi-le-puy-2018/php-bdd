# PHP et base de données :
Pour ce qui est de la liaison avec les bases de données, la manière la plus simple et sécurisée est d'utiliser l'objet PDO.
## Qu'est-ce que l'objet PDO ?

PDO est une classe implantée nativement dans le cœur du langage PHP. Il permet une interaction simplifiée et sécurisée avec la base de données. 
## Utiliser l'objet PDO en PHP

 1. Initialisation de PDO
 2. Utiliser PDO pour récupérer des données 
 3. Utiliser PDO pour effectuer des modifications dans la base de données

### 1) Initialiser PDO
Pour utiliser PDO, il faut dans un premier temps l'initialiser. C'est dans cette initialisation que l'on va pouvoir renseigner les informations nécessaires à la connexion avec la base de données. 
Ici, la première chose à faire, c'est de créer une variable de type PDO, que nous réutiliseront partout dans le projet. On peu donc créer un fichier *config.php*, par exemple, qui contiendra la déclaration de notre objet PDO  :

	//Tentative de connexion à la base de données.
	try{
		
		//Déclaration de $DB, notre objet PDO
		$DB = new PDO('
			mysql:host=[ _adresse de la base de données_ ];
			dbname=[ _nom de la base de données que l'on va utiliser_ ]',
			'[ _nom d'utilisateur utilisé pour se connecter à la base de données_ ]',
			'[ _Mot de passe utilisé pour se connecter_ ]'
		);
		
		//Définition du mode d'erreur, qui influence sur la "tolérence" des erreurs à montrer
	    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
	} catch(PDOException $e) {
	
		//En cas d'erreur, on peu effectuer des actions
	    echo 'La base de donnée n\'est malheureusement pas disponnible pour le moment. Réessayez plus tard.';
	    
	}

### 2) Utiliser PDO pour récupérer des données
PDO possède de nombreuses méthodes dont fait partie *query* qui permet facilement d'effectuer une requête sur la base, qui va plutôt servir à récupérer les données. 

 - On **stocke notre requête** dans une variable *$requete*. La méthode ***query*** prend en **paramètres la requête qui doit être effectuée** :

	`$requete = $DB->query('SELECT * FROM matieres WHERE 1');`
	
 - On stocke le **résultat de notre requête** dans une variable. ***PDO::FETCH_OBJ*** sert uniquement à indiquer que l'on souhaite récupérer le **résultat sous une forme de tableau d'objet**. Il  est possible de récuprer les données [sous d'autres formes](http://php.net/manual/fr/pdostatement.fetch.php#refsect1-pdostatement.fetch-parameters).

	`$cours = $requete->fetchAll(PDO::FETCH_OBJ);`

 - Pour **vérifier le résultat de votre requête**, vous pouvez utiliser `var_dump($cours);` afin de voir ce que contient le résultat de votre requête.
 - Pour **mettre en forme le résultat** de votre requête, vous devez simplement parcourir le tableau obtenu. Vous pouvez donc utiliser le cas par cas en ciblant précisément une case, ou le parcourir entièrement :
 - **La méthode foreach** :
Il est possible d'utiliser *foreach()* pour parcourir les résultats de la requête et d'en afficher les résultats :

		foreach($cours as $resultat){
			//Afficher le nom du cours, si on a une colonne "nom" dans notre table.
			echo $resultat->nom;
		}
 - **La méthode for :**
Pour ceux qui sont mal à l'aise avec la méthode *foreach()*, il est également possible d'utiliser la méthode *for*, qui reste néanmoins beaucoup moins adaptées voir impossible à utiliser dans certains cas :

		//On récupère le nombre de lignes du tableau où sont stockés les résultats de la requête.
		$nb_results = count($cours);
		for($i = 0; $i < $nb_results; $i++){
			$cours[$i]->nom;
		}
### 3) Utiliser PDO pour effectuer des modifications dans la base de données
PDO, comme dit plus tôt, est la méthode la plus **simple** et **sécurisée** pour intéragir avec la base de données. Et on remarque cela essentiellement avec les méthodes ***prepare*** et ***execute***. 
Pour utiliser cette méthode, on va tout d'abord **stocker les données que l'on va insérer** ou qui vont **remplacer les anciennes données** dans un tableau **associatif** (c'est important).
Chaque clé du tableau doit être nommée de manière **explicite**.

	$values = array(
	    "ID"            =>  [ _identifiant de l'item à update_ ]
	    "nom"           =>  $_POST["nom"],
	    [ _nom de clé_] =>	[ _données_ ]
	);
 
On va stocker la préparation de la requête dans une variable *$requete*. Les deux gros avantages pratiques de ***prepare*** et ***execute*** :

 - On va avoir une insertion de données **sécurisée**. On va pouvoir éviter les injections SQL mais aussi les erreurs de chaînes de caractères, etc...
 - Ces méthodes permettent l'utilisation de *"**variables**"*, ce qui va grandement faciliter la modification et l'adaption des requêtes.

Dans un premier temps, nous allons ***préparer*** notre requête dans notre fameuse variable ***$requete***. C'est dans cette préparation (donc quand on appelle la méthode *prepare*), que l'on va **écrire notre requête** et y **marquer les emplacements de nos variables**.
Les **variables** sont très simples à utiliser. Il suffit de mettre "*:*" devant notre mot, qui va **devenir notre variable** (la fin des variables vient juste en dessous).

		$requete = $DB->prepare('UPDATE [ _nom de la table_ ] SET nom = :nom, [ etc...] WHERE ID = :ID;)

Notre requête étant à présent stokée dans *$requete*, on va maintenant l'**exécuter**. Pour cela, rien de bien compliqué. Nous allons appeler la méthode ***execute*** sur notre requête.

		$requete->execute($values);     
Cette simple ligne va donc lancer l'exécution de notre requête. ***Execute*** va simplement prendre en paramètres un tableau qui va contenir nos variables. Et c'est là que la magie opère.
En fonction du nom des clés saisies dans le tableau *$values* on va pouvoir attribuer une valeur aux variables qui sont présentes dans la requête.
Donc reprenons. ***execute*** va aller executer la requête en se basant sur les données contenues dans le tableau donné en argument. *execute* va analyser le contenu de la requête et remplacer les *:[ _nom de variable]* (ex : "*:nom*") par les valeurs correspondantes dans le tableau "* $values *". Donc si on reprend notre ":*nom*", ***execute*** va aller chercher le contenu de la case "*nom"* dans notre tableau, pour **remplacer** le *:nom* dans la requête avec le contenu de la case *nom* du tableau donné à *execute*.
