<?php
namespace Minijournal\User\Controller;

use Slyboot\Logging\Auth\AuthManager;
use Slyboot\Controller\Controller;
use Minijournal\User\Entity\User;
use Minijournal\User\Form\UserForm;
use Minijournal\User\Manager\UserManager;
use Minijournal\User\Cleaner\UserCleaner;
use Slyboot\Util\Cleaner\HtmlCleaner;
use Slyboot\Util\Cleaner\WhiteSpaceCleaner;
use Slyboot\Util\Security\PasswordSecurityAgent;

/**
 *
 * @author dieng444
 *
 */
class UserController extends Controller
{
    public function loginAction()
    {
        if ($this->request->isMethod('post')) {
            $manager = new UserManager();
            //var_dump($user);die;//if($u)
            $user = $manager->findBy('username', $this->request->getParam('login'));
            if ($user) {
                $hashedPassword = $user->getPassword();
                $isValidPassword =  PasswordSecurityAgent::verify(
                    $this->request->getParam('password'),
                    $hashedPassword
                );

                if ($isValidPassword) {
                    $auth = AuthManager::getInstance();
                    $auth->checkAuthentication($hashedPassword, $this->request->getParam('login'));
                    if ($auth->isConnected()) {
                        if (isset($_SESSION["missed_uri"])) {
                            $missed_uri = $_SESSION["missed_uri"];
                            unset($_SESSION["missed_uri"]);
                            $this->redirect($missed_uri);
                        } else {
                            $this->redirect("/Slyboot-1.1.0/");
                        }
                    } else {
                        return $this->render(
                            'Minijournal::User::Default::login-form.html.twig',
                            array('error' => "Identifiant ou mot de passe incorrect")
                        );
                    }
                } else {
                    return $this->render(
                        'Minijournal::User::Default::login-form.html.twig',
                        array('error' => "Mot de passe incorrect")
                    );
                }
            } else {
                return $this->render(
                    'Minijournal::User::Default::login-form.html.twig',
                    array('error' => "Identifiant ou mot de passe incorrect")
                );
            }
        } else {
            return $this->render('Minijournal::User::Default::login-form.html.twig', array());
        }
    }
    public function signupAction()
    {
        if ($this->request->isMethod('post')) {
            $cleanData = ImageCleaner::cleanup(
                $this->request->getRequest('post'),
                array(new HtmlCleaner, new WhiteSpaceCleaner)
            );
                        
            $user = new User($cleanData);
            $form  = new UserForm($user);
            $userManager = new UserManager();
            if ($form->isValid()) {
                /*************Sécurisation du mot passe**********/
                $hashedPassword = PasswordSecurityAgent::secure($user->getPassword());
                $user->setPassword($hashedPassword);
                /********Enregistrement de l'utilisateur en base*********/
                $userManager->save($user);

                $this->redirect("/Slyboot-1.1.0/login");

            } else {
                return $this->render(
                    'Minijournal::User::Default::signup-form.html.twig',
                    array('form' => $form)
                );
            }
        } else {
            return $this->render('Minijournal::User::Default::signup-form.html.twig', array());
        }

    }
    public function logoutAction()
    {
        $auth = AuthManager::getInstance();
        $auth->logout();
        unset($_SESSION["missed_uri"]);
        $this->redirect("/Slyboot-1.1.0/");
    }
}
