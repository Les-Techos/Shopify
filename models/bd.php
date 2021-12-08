<?php
define('END', "end"); // REtourner par une fonction lors d'un résultat alternatif de celui attendu
define('ALL', "%"); // WildCard retourne tout les résultat en ignorant le paramètre associé
define('NO_CHANGE', "NO_CHANGE"); // Caractère de non défintion

function constructConditionsFilter(...$VALUES){
    $condition = "";
    $flipflop = false;


    foreach($VALUES as list($arg, $value)){

        if(!$flipflop){
            $condition = " WHERE ";
            !$flipflop = true;
        }else $condition .= " AND ";

        $condition .= $arg . " LIKE '" . $value . "'";
    }
    return $condition;
}

/**
 * @brief Retourne un lien vers la DB
 * @return : Lien vers la base de données
 */
function getLinkToDb()
{
    $pdo = new PDO('mysql:host=rg-nas.ddns.net;port=3307;dbname=web4shop', 'lestechos', 'wA3[.RY)hx');
    $pdo->exec("SET CHARACTER SET utf8");

    return $pdo;
}

/** Retourne le résultat de la requête
*   @param $conn : Connexion à la DB
*   @param $table : Table voulant être atteinte
*   @param ...$VALUES : Tableau de dimensions n*2 des champs de la donnée 
*   @return $Resultat de la requête de type interne à mysqli
*
*/
function getDatasLike($conn, $table,  ...$VALUES){

    $query = "SELECT * FROM " . $table . constructConditionsFilter(...$VALUES);
    //echo $query . "<br>";
    $result = $conn->query($query);
    print_r($result);
    return $result;
}

/**
 * @brief : Ajoute une ligne à la base de données
 * @param $conn : Connexion à la DB
 *   @param $table : Table voulant être atteinte
 *   @param ...$VALUES : Tableau de dimensions n*2 des champs de la donnée
 */
function addData($conn, $table,  ...$VALUES){
    $query = "INSERT INTO " . $table . " ";
    $args = "(";
    $vals = "(";
    $flipflop = false;

    foreach($VALUES as list($arg, $value)){

        if(!$flipflop){
            $flipflop = true;
        }else{
            $args .= ", ";
            $vals .= ", ";
        }

        $args .=  $arg;
        $vals .= "'" . $value . "'"; 
    }

    $args .= ")";
    $vals .= ")";

    $query .= $args . " VALUES " . $vals;

    return $conn->query($query);  
}

/**
 * @brief : Supprime une ligne à la base de données
 * @param $conn : Connexion à la DB
 * @param $table : Table voulant être atteinte
 * @param ...$VALUES : Tableau de dimensions n*2 des champs de la donnée
 */
function deleteDatas($conn, $table,  ...$VALUES){
    $query = "DELETE FROM " . $table . " ";
    $flipflop = false;

    foreach($VALUES as list($arg, $value)){

        if(!$flipflop){
            $query .= " WHERE ";
            $flipflop = true;
        }else{
            $query .= " AND ";
        }
        $query .= " " . $arg . " LIKE '" . $value . "' ";
    }

    return $conn->query($query);  
}

/**
 * @brief : Met à jour une ligne à la base de données
 * @param $conn : Connexion à la DB
 * @param $table : Table voulant être atteinte
 * @param ...$VALUES : Tableau de dimensions n*3 des champs de la donnée [nomChamp, oldValue, newVal]
 */
function updateDatas($conn, $table,  ...$VALUES){
    $query = "UPDATE " . $table . " ";
    $condition = " WHERE ";

    $flipflopAND = false;
    $flipflopSET = false;

    foreach($VALUES as list($arg, $oldValue, $newValue)){

        if($newValue != NO_CHANGE) {
            if(!$flipflopSET){
                $flipflopSET = true;
                $query .= " SET ";
            }else $query .= ", ";

            $query .= " $arg = '" . $newValue . "'";
        }

        if(!$flipflopAND){
            !$flipflopAND = true;
        }else $condition .= " AND ";

        $condition .= $arg . " LIKE '" . $oldValue . "'";
    }

    $query .= $condition;
    
    echo $query;
    return $conn->query($query);
}

/**
 * @brief affiche toute une table (Debug)
 * @param $conn : Connexion à la DB
 * @param $table : Table voulant être atteinte
 * @param ...$VALUES : Tableau de dimensions n*1 des champs de la donnée
 */
function dumpAllEntries($conn, $table, ...$Column){
    $res = getDatasLike($conn, $table);
    $buff = getNextRowFrom($res);
    $nbRow = 0;
    while($buff != END){
        echo $nbRow. " - ";
        foreach($Column as $col){
            echo $buff[$col] . " | "; 
        }
        $nbRow++;
        echo "<br>";
        $buff = getNextRowFrom($res);
    }
}

/**
 * @brief Vérifie si l'id est contenu dans la $table
 * @param $conn : Connexion à la DB
 * @param $table : Table voulant être atteinte
 * @param $Column : Colonne cible
 * @param $id : Id à vérifer
 */

function isIdIn($conn, $table, $Column, $id, ...$VALUES){
    $buff = getNextRowFrom(getDatasLike($conn, $table, [$Column, $id], ...$VALUES));
    if(empty($buff[$Column])) return false;
    else return true;
}

function countRowIn($conn, $table, ...$VALUES){
    $query = "SELECT COUNT(*) FROM " . $table . " "; 

    $query .= constructConditionsFilter(...$VALUES);

    $count = 0;

    foreach($conn->query($query) as $row){
        $count = $row["COUNT(*)"];
    }
    return $count;
}

?>