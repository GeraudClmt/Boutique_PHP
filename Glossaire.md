
Déclaration PHP:
<?php ... ?>
Début/fin de code PHP

Variable:
$nom = "Alice";
$age = 30;

Constante:
define("SITE_NAME", "MonSite");
const VERSION = "1.0.0";

Condition IF:
if ($age > 18) { ... } elseif (...) { ... } else { ... }

Boucle while:
$i = 0; while ($i < 5) {
    echo $i; $i++;
    }

Boucle for:
for ($i = 0; $i < 5; $i++) {
     echo $i; 
    }

Boucle foreach:
$prenoms = ["Alice", "Bob"]; 
foreach ($prenoms as $prenom) { 
    echo $prenom; 
    }	

Fonction:
function saluer($nom) {
    return "Bonjour, $nom"; 
    } 
echo saluer("Alice");


Tableau indexé:
$fruits = ["Pomme", "Banane"];

Tableau associatif:	
$personne = ["nom" => "Alice", "age" => 30];

Classe / Objet
class Personne {
    public $nom; 
    function __construct($nom) { 
        $this->nom = $nom; 
        } 
    function saluer() { 
        return "Bonjour, " . $this->nom; 
    }
}
$p = new Personne("Claire");
echo $p->saluer();

Inclusion de fichier	
include 'fichier.php';
require 'fichier.php';	