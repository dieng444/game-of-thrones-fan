<?php
namespace Minijournal\Image\Controller;

use Slyboot\Controller\Controller;
use Minijournal\Image\Manager\ImageManager;
use Minijournal\Image\Entity\Image;
use Minijournal\Image\Cleaner\ImageCleaner;
use Slyboot\Util\Cleaner\HtmlCleaner;
use Slyboot\Util\Cleaner\WhiteSpaceCleaner;
use Minijournal\Image\Form\ImageForm;
use Minijournal\Article\Html\ArticleHtml;
use Minijournal\Article\Manager\ArticleManager;
use Slyboot\Util\Upload\UploadManager;
use \Exception;

/**
 * Classe ImageController : Contrôleur du bundle
 * Images, étends la classe de contrôleur principal
 * @author Macky Dieng
 * @copyright   M1DNR2I - 2015 Univ Caen Basse-Normandie
 * @license CC
 */
class ImageController extends Controller
{
    public function addAction($articleId)
    {
        if ($this->user->isConnected()) {
            if ($this->user->isGrantRole('ROLE_EDITOR')) {
                if ($this->request->isMethod('post')) {
                    $imageManager = new ImageManager();
                   /*******Enregistrement des images flickr via ajax*******/
                    if ($this->request->isXhr()) {
                        $imageFlickr = $this->request->getParam('photosFlickr');
                        $is_ok = true;
                        if (sizeof($imageFlickr) > 0) {
                            foreach ($imageFlickr as $fkimg) {
                                $image = new Image();
                                $image->setName($fkimg['src']);
                                $image->setTitre($fkimg['title']);
                                $image->setArticleId($articleId);
                                $image->setDroit("Public");
                                $image->setPhotographe("dieng444");
                                if (!$imageManager->save($image)) {
                                    $is_ok = false;
                                }
                            }
                            if ($is_ok) {
                                $this->response->getResponse(true);
                            } else {
                                $this->response->getResponse(false);
                            }
                        }
                    } else {
                        /*****Image standard du formulaire*******/
                        $cleanData = ImageCleaner::cleanup(
                            $this->request->getRequest('post'),
                            array(new HtmlCleaner, new WhiteSpaceCleaner)
                        );
                            
                        $image = new Image($cleanData);
                        $form = new ImageForm($image);
                        if ($form->isValid()) {
                            if (isset($_FILES['file']) && $_FILES['file']['name']!=='') {
                                /**
                                 * Modification des infos d'une image (fichier image y compris)
                                 * donc suppression de l'ancienne image
                                 */
                                if ($image->getId()!==null) {
                                    $imageManager->remove($imageManager->find($image->getId()));
                                    unlink('resources/public/uploads/images/articles/'.$image->getName());
                                    $image = UploadManager::upload($cleanData, $_FILES['file']);
                                    $imageManager->save($image);
                                    $id = $imageManager->lastInserId();
                                    return $this->redirect("/Slyboot-1.1.0/image/detail/{$id}");
                                } else {
                                    /**
                                     * Ajout d'une nouvelle image à un article
                                     */
                                    $file = UploadManager::upload($cleanData, $_FILES['file']);
                                    $imageManager->save($file);
                                    return $this->redirect("/Slyboot-1.1.0/article/detail/{$this->request->getParam('articleId')}");
                                }
                            } else {
                                /**
                                 * Mise à jour des infos d'une image existante
                                 * sans modification du fichier image en lui même
                                 * ex : modifier le titre d'une image ou autre chose
                                 */
                                $imageManager->save($image);
                                return $this->redirect("/Slyboot-1.1.0/image/detail/{$image->getId()}");
                            }
                        } else {
                            return $this->render(
                                "Minijournal::Image::Default::image-form.html.twig",
                                array('form' => $form, "articleId" => $articleId)
                            );
                        }
                    }
            
                } else {
                    return $this->render(
                        "Minijournal::Image::Default::image-form.html.twig",
                        array("articleId" => $articleId)
                    );
                }
            } else {
                throw new Exception("Access Denied : You don't have permission to execute this action");
            }
        } else {
            $_SESSION["missed_uri"] = $this->http->getRequestUri();
            $this->redirect("/Slyboot-1.1.0/login");
        }

    }
    public function listAction()
    {
        if ($this->user->isConnected()) {
            if ($this->user->isGrantRole('ROLE_EDITOR')) {
                $viewBuilder = new ArticleHtml();
                $articleManager = new ArticleManager();
                $articles = $viewBuilder->getListView($articleManager->findAll());
                $imageManager = new ImageManager();
                $data = array();
                foreach ($articles as $article) {
                    /**
                     * Renvoyer uniquement les images des articles de
                     * l'utlisateur en cours de session. Donc les articles
                     * dont l'auteur est l'utilisateur connecté.
                     */
                    if ($article->getAuteur()===$this->user->getInfos()->getUsername()) {
                        $images = $imageManager->findAllBy('articleId', $article->getId());
                        if (sizeof($images) > 0) {
                            $article->setImages($images);
                            $data[] = $article;
                        };
                    }
                }
                return $this->render(
                    "Minijournal::Image::Default::image-list.html.twig",
                    array('articles' => $data)
                );
            } else {
                throw new Exception("Access Denied : You don't have permission to execute this action");
            }
        } else {
            $_SESSION["missed_uri"] = $this->http->getRequestUri();
            $this->redirect("/Slyboot-1.1.0/login");
        }
    }
    public function detailAction($id)
    {
        if ($this->user->isConnected()) {
            if ($this->user->isGrantRole('ROLE_EDITOR')) {
                $imageManager = new ImageManager();
                $image = $imageManager->find($id);

                return $this->render("Minijournal::Image::Default::image-detail.html.twig", array('image' => $image));
            } else {
                throw new Exception("Access Denied : You don't have permission to execute this action");
            }
        } else {
            $_SESSION["missed_uri"] = $this->http->getRequestUri();
            $this->redirect("/Slyboot-1.1.0/login");
        }

    }
    public function editAction($id)
    {
        if ($this->user->isConnected()) {
            if ($this->user->isGrantRole('ROLE_EDITOR')) {
                if ($this->request->isMethod('get')) {
                    $manager = new ImageManager();
                    $image = $manager->find($id);
                    //var_dump($image);die;
                    return $this->render(
                        'Minijournal::Image::Default::image-form.html.twig',
                        array('image' => $image)
                    );
                }
            } else {
                throw new Exception("Access Denied : You don't have permission to execute this action");
            }
        } else {
            $_SESSION["missed_uri"] = $this->http->getRequestUri();
            $this->redirect("/Slyboot-1.1.0/login");
        }
    }
    public function removeAction($id)
    {
        if ($this->user->isConnected()) {
            if ($this->user->isGrantRole('ROLE_EDITOR')) {
                $imageManager = new ImageManager();
                $image = $imageManager->find($id);
                $imageManager->remove($image);
                if (is_readable('resources/public/uploads/images/articles/'.$image->getName())) {
                     unlink('resources/public/uploads/images/articles/'.$image->getName());
                }
                
                return $this->redirect("/Slyboot-1.1.0/image/list");
            } else {
                throw new Exception("Access Denied : You don't have permission to execute this action");
            }
        } else {
            $_SESSION["missed_uri"] = $this->http->getRequestUri();
            $this->redirect("/Slyboot-1.1.0/login");
        }
            
    }
}
