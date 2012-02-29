<?php

namespace Brickstorm\SocialGraphBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;


class GraphTwitterExtension extends Extension
{


    function __construct(){
  
      //
    }

    /**
     * appel api
     *
     * @param $message Message à envoyer à Twitter
     * @return array
     */
    function requestAPI($url, $method='GET', $params) {
      
      $tmhOAuth = new tmhOAuth(array(
      'consumer_key' => '',
      'consumer_secret' => '',
      'user_token' => '',
      'user_secret' => '',
      ));
      
      $tmhOAuth->request($method, 
                         $tmhOAuth->url('statuses/update'), 
                         $params
                        );
      
      if ($tmhOAuth->response['code'] == 200) {
        return $tmhOAuth->pr(json_decode($tmhOAuth->response['response'] ));
      } else {
        //  $tmhOAuth->pr(htmlentities($tmhOAuth->response['response']));
        return false;
      }
    }

    /**
     * recherche des tweets
     *
     * @param $message Message à envoyer à Twitter
     * @return array
     */
    function search($q, $nb_results = 100, $since_id = null) {
      
      $results = $this->requestAPI($tmhOAuth->url('/search.json?q='.urlencode($q).'&rpp='.$nb_results.'&since_id='.$since_id.'&include_entities=true');
      
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
     
     $this->requestAPI($tmhOAuth->url('statuses/update'), 
                       'POST', 
                       array('status' => utf8_encode($message))
                       );
    }
}