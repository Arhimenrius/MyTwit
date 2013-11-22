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
//        $memcache_obj = new \Memcache;
//$memcache_obj->connect('localhost', 11211);
//
//$memcache_obj->flush();

        
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
        $last_id = 0;
        $id = $this->get('security.context')->getToken()->getUser()->getID();
        $cache = $this->get('winzou_cache.memcache');
        $server_cache = $cache->fetch('Tweets');
        $user_cache = $cache->fetch($id.'.tweets');
        if(!empty($user_cache))
        {
            $last_id = end($user_cache);
        }
        
        //var_dump($server_cache);
        //var_dump($user_cache);
        
        if(serialize($server_cache) == serialize($user_cache))
        {
            return new JsonResponse(); 
        }
        else
        {
            
            $ajax = $this->get('ajax_helper');
            $answer_last_id = $this->get('config_helper')->returnAnswerLastId($user_cache);
            $ajax->prepareArrayForUpdateTweets($last_id);
            $data = $ajax->prepareArrayForUpdateAnswers($answer_last_id, $server_cache);
            return new JsonResponse($data);
        } 
    }
    
    public function addAnswerAction()
    {
        $data = json_decode($this->get('request')->getContent());
        $this->get('answer_helper')->saveAnswer($data);
        return new Response();
    }
}