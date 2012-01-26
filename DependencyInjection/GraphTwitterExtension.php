<?php

namespace Brickstorm\SocialGraphBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;


class GraphTwitterExtension extends Extension
{


    function __construct(){
  
      //
    }

    /**
     * Envoie un message sur twitter (stat
     * Si le message, une fois encodé en UTF-8, fait plus de 140 caractères, alors il ne sera pas accepté par Twitter.
     *
     * @param $message Message à envoyer à Twitter
     * @return TRUE ou FALSE
     */
    function tweet($message) {

     $tmhOAuth = new tmhOAuth(array(
     'consumer_key' => '',
     'consumer_secret' => '',
     'user_token' => '',
     'user_secret' => '',
     ));
     
     $tmhOAuth->request('POST', $tmhOAuth->url('statuses/update'), array(
     'status' => utf8_encode($message)
     ));
     
     if ($tmhOAuth->response['code'] 
     
     == 200) {
     // En cours de dév, afficher les informations retournées :
     //  $tmhOAuth->pr(json_decode($tmhOAuth->response['response'] 
     
     
     
    ));
     return TRUE;
     } else {
     // En cours de dév, afficher les informations retournées :
     //  $tmhOAuth->pr(htmlentities($tmhOAuth->response['response'] 
     
     
     
    ));
     return FALSE;
     }
    }
}