/*
Voilà le fichier de connection. 

$DB sera notre objet PDO qui va permettre l'interaction avec la base de donnée. 
PDO est une classe intégrée au coeur du langage PHP et qui a pour vocation de permettre la communication et l'intéraction avec la base de donnée.
*/


//Try va "tenter" d'effectuer le code à l'intérieur des accolades. En cas d'erreur, catch va "attraper" les erreurs et avec ce qui est passé en paramètre, nous serons en mesure de récuprer le message d'erreur, qui sera ici stoqué dans "$e" (qui n'est pas encore utilisé dans ce code).
 try{
 
    //Déclaration du PDO. Voir plus bas pour les explications.
    $DB = new PDO('mysql:host=[ _adresse de la base de données_ ];dbname=[ _nom de la base de données que l'on va utiliser_ ]', '[ _nom d'utilisateur utilisé pour se connecter à la base de données_ ]', '[ _Mot de passe utilisé pour se connecter_ ]');
    
    //Déclaration du mode de déclaration des erreurs (définir le niveau de "tolérence" pour afficher les erreurs)
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e) {
    //Si on n'arrive pas à se connecter à la base de données
    echo 'La base de donnée n\'est malheureusement pas disponnible pour le moment. Réessayez plus tard.';
}

/*Explications sur NEW PDO*/
new PDO('
    'mysql:host=[ _adresse de la base de données_ ]' --> on déclare que l'on utilise mysql et l'endroit où la base de données se trouve;
    
    'dbname=[ _nom de la base de données que l'on va utiliser_ ]' --> donc par exemple 'wordpress', 'tp1', ...
    
    '[ _nom d'utilisateur utilisé pour se connecter à la base de données_ ]' --> votre identifiant PHP MyAdmin (sur XAMPP c'est 'root')
    
    '[ _Mot de passe utilisé pour se connecter_ ]' --> le mot de passe utilisé par PHP MyAdmin
    );
