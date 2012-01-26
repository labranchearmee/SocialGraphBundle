manage facebook / twitter interaction

<pre>
      if ($this->get('fos_facebook.api')->getUser() && !$u->getFacebookID()) {
        $em = $this->getDoctrine()->getEntityManager();
        $fbManager = new FacebookManager($this->get('fos_facebook.api'));
        $fbManager->updateUser($u, $em);
      }
</pre>