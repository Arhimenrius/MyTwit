<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;

use MyTwit\MyTwitBundle\Entity\Tweets;

class CacheHelper
{
    protected $_em;
    protected $_cache;
    protected $_security;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em Include database
     * @param type $cache Include cache_helper service
     * @param type $security Include security.context service
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, $cache, $security)
    {
        $this->_em = $em;
        $this->_cache = $cache;
        $this->_security = $security;
    }
    
    /**
     * Function prepare initial cache with tweets if we restart PC.
     */
    public function createTweetsCache()
    {
        $tweets = $this->_em->getRepository('MyTwitMyTwitBundle:Tweets')->findAll();
        if(!$this->_cache->contains('Tweets') && !empty($tweets))
        {
            $ids = array();
            foreach($tweets as $tweet)
            {
                $ids[] = $tweet->getID();
            }
            $this->_cache->save('Tweets', $ids);
        }
    }
    
    /**
     * 
     * @param int $id ID of new tweet
     */
    public function updateTweetsCache($id)
    {
        $tweets = $this->_cache->fetch('Tweets');
        $tweets[] = $id;
        $this->_cache->save('Tweets', $tweets);
    }
    
    /**
     * Create actuall user cache of tweets
     */
    public function createUserCache()
    {
        $user_id = $this->_security->getToken()->getUser()->getID();
        $this->_cache->save($user_id.'.tweets', array('0'));
    }
    
    /**
     * Method for update cache of user.
     * 
     * @param int $ids ID of user to update cache
     */
    public function updateUserCache($ids)
    {
        $user_id = $this->_security->getToken()->getUser()->getID();
        $tweets = $this->_cache->fetch($user_id.'.tweets');
        foreach($ids as $id)
        {
            array_push($tweets, $id);
        }
        $this->_cache->save($user_id.'.tweets',$tweets);
   }
}

?>
