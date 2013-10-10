<?php
namespace MyTwit\MyTwitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutyouController extends Controller {
    /**
     * Method returning About You page
     */
    public function viewAction()
    {
        $tweets = $this->get('tweets_helper')->returnTweetsAboutUser();
        
        return $this->render('MyTwitMyTwitBundle:Index:aboutyou.html.twig', array('user_tweets' => $tweets));
    }
}

?>
