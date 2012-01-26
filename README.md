manage facebook / twitter interaction

<h2>Mise à jour de FOSUser avec les données de FOSFacebook</h2>

<pre>
      if ($this->get('fos_facebook.api')->getUser() && !$u->getFacebookID()) {
        $em = $this->getDoctrine()->getEntityManager();
        $fbManager = new FacebookManager($this->get('fos_facebook.api'));
        $fbManager->updateUser($u, $em);
      }
</pre>


<h2>Récupération des amis</h2>

<pre>
      ...
</pre>