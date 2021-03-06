<?php
namespace Minijournal\Rss\Controller;

use Minijournal\Rss\Entity\Rss;
use Slyboot\Controller\Controller;

/**
 * Class RssConroller : Contoleur du bundle
 * RSS, étends la class de controleur principale
 * @author Elhadj Macky Dieng
 * @copyright   M1DNR2I - 2015
 * @license Académique
 */
class RssController extends Controller
{
    public function displayAction()
    {
        $data = Rss::getRss();
        $flux = simplexml_load_string($data);
        //var_dump($flux->channel->item->enclosure['url']);die;
        return $this->render('Minijournal::Rss::Default::rss.html.twig', array('flux' => $flux));
        //var_dump($news->channel);
        /*foreach($news->channel->item as $item) {
            var_dump($item->title);
        }*/
         
    }
}
