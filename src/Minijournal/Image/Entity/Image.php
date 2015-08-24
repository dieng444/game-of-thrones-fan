<?php
namespace Minijournal\Image\Entity;

use Slyboot\Main\Entity\MainEntity;

class Image extends MainEntity
{
    protected $id;
    protected $articleId;
    protected $name;
    protected $titre;
    protected $photographe;
    protected $droit;
    protected $dateDeCreation;

    /**
     * @method constructeur de la classe
     * @param array $data le tableau des données proveant du formulaire
     */
    public function __construct($data = array())
    {
         //parent::__construct($data);
         $this->initialize($data);
    }
    /**
     * @method Cette méthode permet de charger les setteurs de l'objet
     * en données
     * @param array $data tableau de données de l'article
     * @return void
     */
    public function initialize($data = array())
    {
        foreach ($data as $attribut => $value) {
            if (!empty($value)) {
                $methode = 'set'.ucfirst($attribut);
                if (method_exists($this, $methode)) {
                    $this->$methode($value);
                }
            }
        }
    }
    /**
     * @method Cette méthode permet de vérifier si un image est nouvelle
     * ou pas si oui, alors elle est insérée comme nouvelle image,
     * sinon elle est modifié vu qu'elle existe déjà.
     * @return boolean
     */
    /*public function isNew()
    {
    	if(empty($this->id)){
    		return true;
    	}else
    		return false;
    }*/
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getArticleId()
    {
        return $this->articleId;
    }

    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function getPhotographe()
    {
        return $this->photographe;
    }

    public function setPhotographe($photographe)
    {
        $this->photographe = $photographe;
    }

    public function getDroit()
    {
        return $this->droit;
    }

    public function setDroit($droit)
    {
        $this->droit = $droit;
    }

    public function getDateDeCreation()
    {
        return $this->dateDeCreation;
    }

    public function setDateDeCreation($dateDeCreation)
    {
        $this->dateDeCreation = $dateDeCreation;
    }
}
