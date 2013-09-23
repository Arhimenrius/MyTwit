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
        $answers = $this->_em->getRepository('MyTwitMyTwitBundle:Answers')->findAll();
        if(!$this->_cache->contains('Tweets_answers') && !empty($answers))
        {
            $i = 0;
            foreach($answers as $answer)
            {
                $ids[$i]['id'] = $answer->getID();
                $ids[$i]['for'] = $answer->getAnswersFor()->getID();
                $i++;
            }
            $this->_cache->save('Tweets_answers', $ids);
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
        $this->_cache->save($user_id.'.answers', array('0'));
    }
    
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
