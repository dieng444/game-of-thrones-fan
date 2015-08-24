<?php
namespace Minijournal\User\Form;

use Slyboot\Main\Form\MainForm;
use Slyboot\Main\Entity\MainEntity;
use Minijournal\User\Entity\User;
use Slyboot\Util\Validator\MainValidator;
use Slyboot\Util\Validator\ValidatorInterface;

/**
 * Class UserForm : Class de formulaire de l'entité User
 * @author Macky Dieng
 * @copyright   M1DNR2I - 2015
 * @license Académique
 */
class UserForm extends MainForm implements ValidatorInterface
{

    /**
     * L'objet utilisateur à gérer
     * @var Minijournal\User\Entity\User :
     **/
    protected $user;
    /**
    * Constructeur de la classe
    * @param User $user
    */
    public function __construct(User $user = null)
    {
        parent::__construct();
        $this->user = $user;
    }
    /**
     * Renvoie l'utilisateur à afficher dans le formulaire
     * @method getFormEntity
     * @return Minijournal\User\Entity\User
     */
    public function getFormEntity()
    {
        return $this->user;
    }
    /**
     * Appelle le gestionnaire d'utilitaire des
     * validateurs, pour ainsi effectuer la validation
     * d'un article donné.
     * @param array $validators : tabeleau de validateurs optionnel
     * @param array $article : article à valider
     */
    public static function validate(MainEntity $entity, $validators)
    {
        $mainValidator = new MainValidator();
        $result = $mainValidator->addValidator($validators, $entity);
        return $result;
    }
    /**
     * Permet aux développeurs de spécifier les validateurs
     * à utiliser pour le formulaire courant
     */
    public function validatorsToUse()
    {
        $acceptValidators = array(
                                  "FieldLengthValidator",
                                  "SelectListValidator",
                                  "EmptyFieldValidator"
                                 );

        return $acceptValidators;
    }
    /**
     * Permet de préciser les directives de validations
     * des attirbuts de l'objet courant (User ici)
     * @return Minijournal\User\Entity\User
     */
    public function getValidationInfos()
    {
        $infos = array("username" => array("options" =>
                                           array(
                                                  "_blank" => false,
                                                  "_min_length" => 4,
                                                  "_empty_error_msg" => "Le <b>nom d'utilisateur</b> est obligatoire",
                                                  "_length_error_msg" => "Le <b>nom d'utilisateur</b> ne pas faire moins de 4 caractères"
                                                )
                                        ),
                       "password" => array("options" =>
                                         array(
                                                "_min_length" => 4,
                                                "_blank" => false,
                                                "_empty_error_msg" => "Le <b>mot de passe</b> est obligatoire",
                                                "_length_error_msg" => "Le <b>mot de passe</b> ne pas faire moins de 4 caractères"
                                              )
                                       ),
                       "firstname" => array("options" =>
                                         array(
                                                "_min_length" => 3,
                                                "_blank" => false,
                                                "_empty_error_msg" => "Le <b>prénom</b> est obligatoire",
                                                "_length_error_msg" => "Le <b>prénom</b> ne pas faire moins de 3 caractères"
                                              )

                                       ),
                        "lastname" => array("options" =>
                                         array(
                                               "_blank" => false,
                                               "_min_length" => 3,
                                               "_empty_error_msg" => "Le <b>nom</b> est obligatoire",
                                               "_length_error_msg" => "Le <b>nom</b> ne pas faire moins de 3 caractères"
                                              )
                                        ),
                        "role" => array("options" =>
                                        array(
                                                "_blank" => false,
                                                "_empty_error_msg" => "Le <b>profil</b> est obligatoire",
                                                "_accepted_values" => array("1","2"),
                                                "_accepted_values_msg" => "Le champ <b>role</b> ne peut contenir
                                                                          que <b>1</b> ou <b>2</b>"
                                             )
                                        ),
                );

        return $infos;
    }
}
