<?php

namespace MyTwit\MyTwitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyTwit\MyTwitBundle\Entity\Tweets;
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
        return $this->render('MyTwitMyTwitBundle:Index:profil.html.twig', array('user_tweets' => $tweets, 'user_data' => $user));
    }
}

?>
