<?php

namespace MyTwit\MyTwitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProfilController extends Controller {
    //put your code here
    
    public function viewAction($username = '')
    {
        if($username == '')
        {
            $username = $this->get('security.context')->getToken()->getUser()->getNickname();
        }
        $tweets = $this->get('tweets_helper')->returnTweetsOfUser($username);
        $user = $this->get('users_helper')->returnUserData($username);
        $observed = $this->get('users_helper')->returnObservedArray($this->get('security.context')->getToken()->getUser()->getObserved());
        if(in_array($user['Id'], $observed))
        {
            $observed = true;
        }
        else
        {
            $observed = false;
        }
        return $this->render('MyTwitMyTwitBundle:Index:profil.html.twig', array('user_tweets' => $tweets, 'user_data' => $user, 'observed' => $observed));
    }
    
    public function changeobservedAction()
    {
        $data = json_decode($this->get('request')->getContent());
        $this->get('users_helper')->changeObserved($data);
        return new Response();
    }
}

?>
