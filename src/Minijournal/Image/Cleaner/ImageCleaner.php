<?php
namespace Minijournal\Image\cleaner;

use Slyboot\Util\Cleaner\Cleaner;
use Slyboot\Util\Cleaner\CleanerInterface;

/**
 * Class ImageCleaner : Gère le nettoyage de
 * l'entité image
 * @author Macky Dieng
 * @license MIT - http://opensource.org/licenses/MIT
 * @copyright 2015 the author
 */
class ImageCleaner implements CleanerInterface
{
    /**
     * Variable d'instance de la classe utilitaire
     * qui gère les nettoeyrs.
     * @var \Utils\Cleaners\Cleaner
     */
    private static $class;
    /**
     * @static méthode static appellant
     * le gestionnaire d'utilitaire des
     * nettoyeurs pour ainsi effectuer le nettoyage
     * @param array $cleaners : tabeleau de nettoyeurs
     * @param array $data : données à nettoyer
     */
    public static function cleanup($data, $cleaners = array())
    {
        self::$class = new Cleaner();

        $cleanData = self::$class->addCleaner($cleaners, $data);

        return $cleanData;
    }
}
