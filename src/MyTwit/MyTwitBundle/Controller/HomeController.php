<?php

namespace MyTwit\MyTwitBundle\Controller;

use MyTwit\MyTwitBundle\Forms\ConfigForm;
use MyTwit\MyTwitBundle\Forms\TweetForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyTwit\MyTwitBundle\Entity\Tweets;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class HomeController extends Controller
{
    /**
     * Controller return home_page for logged user
     * @return view
     */
    public function homeAction()
    {
        $cache = $this->get('cache_helper');
        $cache->createTweetsCache();
        $cache->createUserCache();

        $form = $this->createForm(new TweetForm());
        return $this->render('MyTwitMyTwitBundle:Index:home.html.twig', array(
            'form' => $form->createView()
        ));  
    }
    
    /**
     * Action after user create tweet
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addTweetAction()
    {
         $data = json_decode($this->get('request')->getContent());
                $tweet = new Tweets();
                
                $tweet_helper = $this->get('tweets_helper');
                $tweet_helper->prepareToAdd($tweet, $data);
                $tweet_helper->save($tweet);
        return new Response();
    }
    
    /**
     * Action when user open this page. Get all tweets
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function updateTweetsAction()
    {
        $id = $this->get('security.context')->getToken()->getUser()->getID();
        $cache = $this->get('winzou_cache.memcache');
        $tweets_cache = $cache->fetch('Tweets');
        $user_cache = $cache->fetch($id.'.tweets');
        
        //print_r($tweets_cache);
        //print_r($user_cache);
        if(end($tweets_cache) == end($user_cache))
        {
            return new JsonResponse(); 
        }
        else
        {
            $t = (array($tweets_cache, $user_cache));
            $ajax = $this->get('ajax_helper');
            $data_array = $ajax->prepareArrayForUpdateTweets(end($user_cache));
            return new JsonResponse($data_array);
        } 
    }
    
    public function addAnswerAction()
    {
        $data = json_decode($this->get('request')->getContent());
        $this->get('answer_helper')->addAnswer($data);
        return new Response();
    }
}