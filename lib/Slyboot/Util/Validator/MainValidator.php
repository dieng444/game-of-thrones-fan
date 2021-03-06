<?php
namespace Slyboot\Util\Validator;

use Slyboot\Main\Entity\MainEntity;

/**
 * Class MainValidator : gestionnaire des validateurs
 * permettant d'ajouter des validateurs.
 * @author Macky Dieng
 * @license MIT - http://opensource.org/licenses/MIT
 * @copyright 2015 - the author
 */
class MainValidator
{

    /**
     * @method méthode permettant d'ajouter des validateurs
     * au gestionnaire.
     * @param array $validators : tableau de validateurs
     * @param Article $article : L'objet Artilce à valider
     * @return array
     */
    public function addValidator($validators, MainEntity $entity)
    {
        $result = array();
        foreach ($validators as $validator) {
            $result[] = $validator::validate($entity, array());
        }
        return $result;
    }
}
