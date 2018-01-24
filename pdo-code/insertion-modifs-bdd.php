
$values = array(
    [ _nom de variable_ ]   =>  [ _contenu de la variable_ ],
);

$requete = $DB->prepare('UPDATE [ _nom de la table_ ] SET nom = :nom, [ etc...] WHERE ID = :ID;)
//ou
$requete = $DB->prepare('INSERT INTO [ _nom de la table_ ] ([ _nom de colonne 1_ ], [ _nom de colonne 2_ ], ...) VALUES (:[ _variabe_ ], :[ _variabe_ ], ...)');

$requete->execute($values); 
