<?php

namespace Minijournal\Achat\Controller;

use Slyboot\Controller\Controller;

class AchatController extends Controller
{
    public function contributionAction()
    {
        /*if(isset($_POST)) {
            
        }*/
        $pathifle = "/users/21410938/www-dev/Slyboot-1.1.0/eTransactions/param/pathfile";
        
        $data = array(
                    "pathfile" => $pathifle,
                    "caddie" => "2015_04_08_05224",
                    "merchant_id" => "013044876511111",
                    "amount" => "200",
                    "normal_return_url" => "https://dev-21410938.users.info.unicaen.fr/Slyboot-1.1.0/index.php?bundle=achat&action=normal",
                    "cancel_return_url" => "https://dev-21410938.users.info.unicaen.fr/Slyboot-1.1.0/response/response.php",
                    "automatic_response_url" => "https://dev-21410938.users.info.unicaen.fr/Slyboot-1.1.0/index.php?bundle=achat&action=response",
                    );
       
         $param = "";
        foreach ($data as $k => $v) {
            $param .= $k."=".$v." ";
        }
         $result = exec("/users/21410938/www-dev/Slyboot-1.1.0/eTransactions/bin/request {$param}");
         
         //list($code, $error, $buffer) = explode('!',$result);
         $var = explode('!', $result);
         //$var[3] == détail
        if ($var[1]==0) {
            echo $var[3];
            die;
        }
         
        
        //return $this->render('Templates/paiment.tpl.php',$result);
        
    }
    public function responseAction()
    {
        var_dump($_POST);
        
        $result = exec("/users/21410938/www-dev/TP_journal_PHP_Elhadj_Macky_Dieng_v6/eTransactions/bin/response message={$_POST['DATA']} pathfile={$pathifle}");
        
        echo $result;
        die;
        
    }
    public function normalAction()
    {
        var_dump($_POST);
    }
}
