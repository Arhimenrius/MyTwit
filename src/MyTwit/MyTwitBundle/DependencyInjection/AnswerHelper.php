<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;

use MyTwit\MyTwitBundle\Entity\Answers;
use MyTwit\MyTwitBundle\Entity\Tweets;

class AnswerHelper
{
    protected $_em;
    protected $_security;
    protected $_request;
    protected $_cache;
    protected $_hashtag;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em Include database service
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, $security, $cache, $hashtag)
    {
        $this->_em = $em;
        $this->_security = $security;
        $this->_cache = $cache;
        $this->_hashtag = $hashtag;
    }
    
    public function addAnswer($data)
    {
        $tweet = $this->_em->getRepository('MyTwitMyTwitBundle:Tweets')->findBy(array('token' => $data->token));
        $answer = new Answers();
        $answer -> setAuthor($this->_em->getRepository('MyTwitMyTwitBundle:User')->find($this->_security->getToken()->GetUser()->getID()));
        $answer -> setContent($data->content);
        $answer -> setDate(new \DateTime("now"));
        $answer -> setHashtags($this->_hashtag->handleHashtags($answer));
        $answer -> setAnswersFor($tweet[0]);
        
        $this->_em->persist($answer);
        $this->_em->flush();
    }
}
?>
