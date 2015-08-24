<?php
namespace Minijournal\User\cleaner;

use Slyboot\Util\Cleaner\Cleaner;
use Slyboot\Util\Cleaner\CleanerInterface;

/**
 * Class UserCleaner : Nettoie les infos de l'utilisateur,
 * avant de leurs envoyées en base.
 * @author Macky Dieng
 * @copyright   M1DNR2I - 2015
 * @license MIT
 */
class UserCleaner implements CleanerInterface
{
    /**
     * Variable d'instance de la classe utilitaire
     * qui gère les nettoyeurs.
     * @var \Utils\Cleaners\Cleaner
     */
    private static $class;
    /**
     * @static Permet d'ajouter des nettoyeurs
     * à la class globale de nettoyeur.
     * @param array $cleaners : tabeleau de nettoyeurs
     * @param array $data : données à nettoyer
     */
    public static function cleanup($data, $cleaners)
    {
        self::$class = new Cleaner();

        $cleanData = self::$class->addCleaner($cleaners, $data);

        return $cleanData;
    }
}
