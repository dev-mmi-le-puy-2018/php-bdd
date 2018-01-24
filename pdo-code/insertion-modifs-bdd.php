
//Tableau qui va stoquer les données que le vont inserer / modifier dans la bdd
$values = array(
    "ID"                =>  [ _identifiant de l'item à update_ ]
    "nom"           =>  $_POST["nom"],
);
 
//On va stoquer la préparation de la requête. C'est un moyen de sécuriser la requête et d'éviter les erreurs. De plus, il est possible d'avoir accès est des "VARIABLES"
//par exemple : on va choisir le champs, dans la requête d'exemple c'est "nom" et on va lui attribuer la valeur ":nom". Quand on met ":" devant un mot dans un PDO->prepare, cela va tout simplement permettre de dire, je veux que tu utilises la case "nom" d'un tableau que je vais te donner ensuite. Attention, ":nom" pourrait être ":valeur", ":chose", on s'en fou, tout ce qui compte c'est que ce qu'il y a après les ":" soit le nom d'une case du tableau !

$requete = $DB->prepare('UPDATE [ _nom de la table_ ] SET nom = :nom, [ etc...] WHERE ID = :ID;)
    
//Là on lui dit d'éxecuter notre requête avec les valeurs stoquées dans le tableau $values
$requete->execute($values); 
