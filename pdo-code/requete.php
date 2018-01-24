require_once( [ _fichier avec déclaration de $DB dedans_ ] );

$requete = $DB->query('SELECT [ _colonnes à recupérer_ ] FROM [ _table(s)_ ] WHERE [ _condition_] ');

$resultats = $requete->fetchAll(PDO::FETCH_OBJ);

foreach($resultats as $resultat){
 	echo $resultat-> [ _colonne à afficher_ ];
}
