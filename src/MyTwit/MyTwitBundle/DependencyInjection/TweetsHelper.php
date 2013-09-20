<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;

use MyTwit\MyTwitBundle\Entity\Tweets;

class TweetsHelper
{
    protected $_em;
    protected $_security;
    protected $_request;
    protected $_cache;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em Include database service
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, $security, $cache)
    {
        $this->_em = $em;
        $this->_security = $security;
        $this->_cache = $cache;
    }
    
    /**
     * 
     * @param \MyTwit\MyTwitBundle\Entity\Tweets $tweet Instance of Tweets
     * @param array $data Data from form
     */
    public function prepareToAdd(Tweets $tweet, $data)
    {
        $tweet->setAuthor($this->_em->getRepository('MyTwitMyTwitBundle:User')->find($this->_security->getToken()->GetUser()->getID()));
        $tweet->setContent($data->content);
        $tweet->setDate(new \DateTime("now"));
    }
    
    /**
     * 
     * @param \MyTwit\MyTwitBundle\Entity\Tweets $tweet Instance of Tweets
     */
    public function save(Tweets $tweet) {
        if(!$tweet->getId())
        {
            $this->_em->persist($tweet);
        }
        $this->_em->flush();  
        $this->_cache->updateTweetsCache($tweet->getId());
    }

}

?>
