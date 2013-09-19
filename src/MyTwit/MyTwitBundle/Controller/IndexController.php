<?php

namespace MyTwit\MyTwitBundle\Controller;

use MyTwit\MyTwitBundle\Forms\ConfigForm;
use MyTwit\MyTwitBundle\Forms\TweetForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyTwit\MyTwitBundle\Entity\Tweets;
use Symfony\Component\HttpFoundation\Response;


class IndexController extends Controller
{
    public function homeAction()
    {
        $tweets = $this->getDoctrine()->getRepository('MyTwitMyTwitBundle:Tweets')->returnNewTweets();
        $form = $this->createForm(new TweetForm());

            
            
        $cache = $this->get('winzou_cache.memcache');
        $cache->save('bar', array('foo', 'bar'));
        var_dump($cache);
            
        
        return $this->render('MyTwitMyTwitBundle:Index:home.html.twig', array(
            'tweets' => $tweets,
            'form' => $form->createView()
        ));
    }
    
    public function addtwitAction()
    {
         $data = json_decode($this->get('request')->getContent());
                $tweet = new Tweets();
                $tweet->setAnswerFor(0);
                $tweet->setAuthor($this->getDoctrine()->getRepository('MyTwitMyTwitBundle:User')->find($this->get('security.context')->getToken()->GetUser()->getID()));
                $tweet->setContent($data->content);
                $tweet->setDate(new \DateTime("now"));
                $tweet_helper = $this->get('tweets_helper');
                $tweet_helper->save($tweet);
        return new Response(print_r($data, 1));
    }
}