manage facebook / twitter interaction

<h1>Facebook</h1>
<h2>Mise à jour de FOSUser avec les données de FOSFacebook</h2>
It's a pity but it took me quite a while to understand how simple it was... Part of the reason was that there was no tutorial.


<pre>
      if ($this->get('fos_facebook.api')->getUser() && !$u->getFacebookID()) {
        $em = $this->getDoctrine()->getEntityManager();
        $fbManager = new FacebookManager($this->get('fos_facebook.api'));
        $fbManager->updateUser($u, $em);
      }
</pre>


<h2>Récupération des amis</h2>

<pre>
      $fbManager = new FacebookManager($this->get('fos_facebook.api'));
      $fbManager->getFriends()
</pre>


<h2>Post a stream</h2>
<pre>
      $fbManager = new FacebookManager($this->get('fos_facebook.api'));
      $fbManager->updateStatus($link, $message);
</pre>


<h1>Twitter</h1>

<h2>Post a tweet</h2>
<pre>
      ...
</pre>