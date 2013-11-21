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
        $ids_for_answers = '';
        if(!$this->_cache->contains('Tweets') && !empty($tweets))
        {
            $ids = array();
            foreach($tweets as $tweet)
            {
                $ids_for_answers .= ',' . $tweet->getID();
                $ids[] = array('ID' => $tweet->getID(), 'Answers' => array());
            }
          
            $tweets_ids = substr($ids_for_answers, 1);
            if($tweets_ids != '')
            {
                $where = 'a.answersFor IN ('.$tweets_ids.')';
                $query = $this->
                        _em->
                        createQueryBuilder()
                        ->select('a')
                        ->from('MyTwitMyTwitBundle:Answers', 'a')
                        ->where($where);
                $answers = $query->getQuery()->getResult();
                
                $key = '';
                foreach ($answers as $key => $answer)
                {
                    foreach ($ids as $keys => $tweet)
                    {
                        if($tweet['ID'] == $answer->getAnswersFor()->getID())
                        {
                            $ids[$keys]['Answers'][] = $answer->getID();
                            break;
                        }
                    }   
                }
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
        $tweets[] = array('ID'=> $id, 'Answers' => array());
        $this->_cache->save('Tweets', $tweets);
    }
    
    /**
     * Create actuall user cache of tweets
     */
    public function createUserCache()
    {
        $user_id = $this->_security->getToken()->getUser()->getID();
        $this->_cache->save($user_id.'.tweets', array());
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
   
   public function updateAnswersForTweets($id, $answer_for)
   {
       $tweets = $this->_cache->fetch('Tweets');
       $key = '';
       foreach ($tweets as $keys => $tweet)
       {
           if($tweet['ID'] == $answer_for)
           {
               $key = $keys;
           }
       }
       $tweets[$key]['Answers'][] = $id;
       $this->_cache->save('Tweets', $tweets); 
   }
}

?>
