<?php

namespace MyTwit\MyTwitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ObservedController extends Controller  {
    public function viewAction()
    {
        
        $user = $this->get('users_helper')->returnObservedUsers();
        if(!empty($user))
        {
            $observed_user = $this->get('users_helper')->searchUserOfTheId($user);
        }
        else
        {
            $observed_user = 'Nikogo nie obserwujesz';
        }
        return $this->render('MyTwitMyTwitBundle:Index:observed.html.twig', array('users_data' => $observed_user));
    }
}

?>
