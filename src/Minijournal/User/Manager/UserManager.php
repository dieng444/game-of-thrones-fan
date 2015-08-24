<?php
namespace Minijournal\User\Manager;

use Slyboot\Main\Manager\MainManager;
use Slyboot\Main\Entity\MainEntity;

/**
 * Class UserManager : Gère tout ce qui est
 * inétractions avec la base de données.
 * @author Macky Dieng
 * @license MIT
 */
class UserManager extends MainManager
{
    /**
     * @var string : le nom de la table sur laquelle
     * les opérations vont s'effectuées.
     */
    const TABLE_NAME = 'user';
    /**
     * @var string :namespace de la classe
     * courante
     */
    const OBJ_CLASS_NAME = '\\Minijournal\\User\\Entity\\User';
    /**
     * @static méthode static renvoyant la
     * chaîne de réquête sql à exécuter à la classe
     * parente
     * @return string
     */
    protected static function getRequete()
    {
        $requete = ' SET role = :role, username = :username, password = :password,
                    status = :status, firstname = :fname,
                    lastname = :lname';

        return $requete;
    }
    /**
     * @static : méthode static permettant
     * d'exécuter les réquête sql
     * @param $stm : la réquête à exécuter
     * @param $user : l'objet article sur lequel
     * l'exécution doit s'effectuer
     * @param $mode : le mode d'exécution de la requête
     * (insert ou update)
     * @return void
     */
    protected static function bind($stm, MainEntity $user, $mode)
    {
        if ($mode =='update') {
           //Ici juste vérifier si l'id du user n'est pas null ($user->getId())
           //si oui, c'est que l'on est en mode insert sinon c'est l'update
            $stm->bindValue(':id', (int)$user->getId());
        }
        $stm->bindValue(':role', $user->getRole());
        $stm->bindValue(':username', $user->getUsername());
        $stm->bindValue(':password', $user->getPassword());
        $stm->bindValue(':status', $user->getStatus());
        $stm->bindValue(':fname', $user->getFirstname());
        $stm->bindValue(':lname', $user->getLastname());

        return $stm->execute();
    }
}
