<?php

namespace Application\FOS\FacebookBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;


class GraphFacebookExtension extends Extension
{
    protected $facebook    = null;
    protected $friends     = -1;
    protected $user_datas  = -1;

    function __construct(\BaseFacebook $facebook){
  
      $this->facebook = $facebook;

      //on vérifie si l'utilisateur a une session facebook active
      $this->session = $this->facebook->getSession();
      if (!$this->session)
      {
        //sinon il doit s'identifier
        $this->checkLogin();
      }

      //s'il a une session active, on vérifie si elle est valide pour notre application
      try
      {
        $this->uid  = $this->facebook->getUser();
        $this->fbme = $this->facebook->api('/me');
      }
      catch (FacebookApiException $e)
      {
        //sinon il doit à nouveau s'identifier
        $this->checkLogin();
      }
    }


    //redirect to login
    public function checkLogin() {
    
    }

    //get friends
    public function getFriends()
    {
      //récupération des amis via FQL
      $query = "SELECT name, uid, pic_square FROM user WHERE uid in (SELECT uid2 FROM friend WHERE uid1 = ".$this->uid.")";
      $this->friends = $this->facebook->api(array(
          'method'    => 'fql.query',
          'query'     => $query,
          'callback'  => ''
      ));
      
      
      return $this->friends;
    }

    //get user data
    public function getData($field=null, $table='user')
    {
      if (!isset($this->user_datas['table'])) {
        $this->user_datas[$table] = self::loadFqlTable($this->uid, $field, $table);
      }

      if ($field) {
        return isset($this->user_datas[$table][$field]) ? $this->user_datas[$table][$field] : null;
      } else {
        return isset($this->user_datas[$table]) ? $this->user_datas[$table] : null;
      }
    }

    //update status
    public function executeUpdateStatus($link, $message)
    {
      try
      {
        //un simple appel a l'api suffit à poster un nouveau status sur le profile de l'utilisateur
        $facebook->api('/me/feed', 'POST',
                        array(
                          'link'    => $link,
                          'message' => $message
                      ));

        return true;
      }
      catch (FacebookApiException $e)
      {
        return false;
      }
    }

    //api get data
    public static function loadFqlTable($uid, $table='user'){
      try {

        $query = 'SELECT * FROM '.$table.' WHERE uid="'.intval($uid).'"';
        $rows = skFacebook::getFacebookClient()->api_client->fql_query($query);

        return $rows[0];

      } catch (Exception $e){
        return null;
      }
    }
}