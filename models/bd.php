<?php
define('END', "end"); // REtourner par une fonction lors d'un résultat alternatif de celui attendu
define('ALL', "%"); // WildCard retourne tout les résultat en ignorant le paramètre associé
define('NO_CHANGE', "NO_CHANGE"); // Caractère de non défintion

/**
 * Build da conditionnal filter used in queries
 *
 * @param [type] ...$VALUES
 * @return void
 */
function constructConditionsFilter(...$VALUES)
{
    $condition = "";
    $flipflop = false;

    foreach ($VALUES as list($arg, $value)) {

        if (!$flipflop) {
            $condition = " WHERE ";
            !$flipflop = true;
        } else $condition .= " AND ";

        $condition .= $arg . " LIKE '" . $value . "'";
    }
    return $condition;
}

/**
 * Get the Columns name of $tableName
 *
 * @param [type] $tableName
 * @return void
 */
function getColumnName($tableName){
    $query = 'SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "' . $tableName .'"';
    $res = $GLOBALS['conn']->query($query);
    $res = $res->fetchAll(PDO::FETCH_COLUMN,3);
    return $res;
}

/**
 * @brief Retourne un lien vers la DB
 * @return : Lien vers la base de données
 */
function getLinkToDb()
{
    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=rg-nas.ddns.net;port=3307;dbname=web4shop', 'lestechos', 'wA3[.RY)hx');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET CHARACTER SET utf8');
    } catch (PDOException $e) {
        throw "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
    return $pdo;
}

/** Retourne le résultat de la requête
 *   @param $conn : Connexion à la DB
 *   @param $table : Table voulant être atteinte
 *   @param ...$VALUES : Tableau de dimensions n*2 des champs de la donnée 
 *   @return $Resultat de la requête de type interne à mysqli
 *
 */
function getDatasLike($table, &$res,  ...$VALUES)
{
    try {
        $query = "SELECT * FROM " . $table . constructConditionsFilter(...$VALUES);
        $result = $GLOBALS['conn']->query($query);
        $res  = $result->fetchAll();
        if($res == null) return false;
        else return true;
    } catch (PDOException $e) {
        throw new Exception("Erreur !: " . $e->getMessage() . "<br/>");
        die();
    }
    
}

/**
 * @brief : Ajoute une ligne à la base de données
 * @param $conn : Connexion à la DB
 *   @param $table : Table voulant être atteinte
 *   @param ...$VALUES : Tableau de dimensions n*2 des champs de la donnée
 */
function addData($table,  $VALUES)
{
    $query = "INSERT INTO " . $table . " ";
    $args = "(";
    $vals = "(";
    $flipflop = false;

    foreach ($VALUES as [$arg, $value]) {

        if (!$flipflop) {
            $flipflop = true;
        } else {
            $args .= ", ";
            $vals .= ", ";
        }

        $args .=  $arg;
        $vals .= "'" . $value . "'";
    }

    $args .= ")";
    $vals .= ")";

    $query .= $args . " VALUES " . $vals;
    //print($query);
    return $GLOBALS['conn']->query($query);
}

/**
 * @brief : Supprime une ligne à la base de données
 * @param $conn : Connexion à la DB
 * @param $table : Table voulant être atteinte
 * @param ...$VALUES : Tableau de dimensions n*2 des champs de la donnée
 */
function deleteDatas($table,  ...$VALUES)
{
    $query = "DELETE FROM " . $table . " ";
    $flipflop = false;

    foreach ($VALUES as list($arg, $value)) {

        if (!$flipflop) {
            $query .= " WHERE ";
            $flipflop = true;
        } else {
            $query .= " AND ";
        }
        $query .= " " . $arg . " LIKE '" . $value . "' ";
    }

    return $GLOBALS['conn']->query($query);
}

/**
 * @brief : Met à jour une ligne à la base de données
 * @param $conn : Connexion à la DB
 * @param $table : Table voulant être atteinte
 * @param ...$VALUES : Tableau de dimensions n*3 des champs de la donnée [nomChamp, oldValue, newVal]
 */
function updateDatas($table,  ...$VALUES)
{
    $query = "UPDATE " . $table . " ";
    $condition = " WHERE ";

    $flipflopAND = false;
    $flipflopSET = false;

    foreach ($VALUES as list($arg, $oldValue, $newValue)) {

        if ($newValue != NO_CHANGE) {
            if (!$flipflopSET) {
                $flipflopSET = true;
                $query .= " SET ";
            } else $query .= ", ";

            $query .= " $arg = '" . $newValue . "'";
        }

        if (!$flipflopAND) {
            !$flipflopAND = true;
        } else $condition .= " AND ";

        $condition .= $arg . " LIKE '" . $oldValue . "'";
    }

    $query .= $condition;

    //echo $query;
    return $GLOBALS['conn']->query($query);
}

/**
 * @brief Vérifie si l'id est contenu dans la $table
 * @param $conn : Connexion à la DB
 * @param $table : Table voulant être atteinte
 * @param $Column : Colonne cible
 * @param $id : Id à vérifer
 */

function isIdIn($table, $Column, $id, ...$VALUES)
{
    getDatasLike($table,$buff, [$Column, $id], ...$VALUES);
    if (empty($buff[$Column])) return false;
    else return true;
}

function countRowIn($table, ...$VALUES)
{
    $query = "SELECT COUNT(*) FROM " . $table . " ";

    $query .= constructConditionsFilter(...$VALUES);

    $count = 0;

    foreach ($GLOBALS['conn']->query($query) as $row) {
        $count = $row["COUNT(*)"];
    }
    return $count;
}

function getMaxIdIn($table, $col_name){
    $query = "SELECT MAX($col_name) FROM $table";
    $res = $GLOBALS['conn']->query($query);
    $res = $res->fetchAll();
    $res = $res[0]["MAX($col_name)"];
    return (int) $res;
}

$GLOBALS['conn'] = getLinkToDb();
?>