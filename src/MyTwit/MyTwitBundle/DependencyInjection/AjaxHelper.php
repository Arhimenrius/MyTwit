<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;
use MyTwit\MyTwitBundle\Entity\Tweets;

/**
 * Class for prepare data for AJAX
 */
class AjaxHelper
{
    protected $_em;
    protected $_cache;
    protected $_user_cache;
    protected $_ids = array();
    protected $_tweets_array = array();
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em Include database service
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, $cache)
    {
        $this->_em = $em;
        $this->_cache = $cache;
    }
    /**
     * Get data from tweets and prepare array
     */
    
    public function prepareArrayForUpdateTweets($last_id)
    {
        $query = $this->_em->createQueryBuilder()->select('t')->from('MyTwitMyTwitBundle:Tweets', 't')
                ->where('t.id > :last_id')
                ->setParameter('last_id', $last_id);
        $tweets = $query->getQuery()->getResult();
        $all_data = array();
        foreach($tweets as $key => $value)
        {
            $this->_ids[] = $value->getID();
            $this->_tweets_array[] = array(
                'ID' => $value->getID(),
                'Author' => $value->getAuthor()->getNickname(),
                'Email' => $value->getAuthor()->getEmail(),
                'Content' => $value->getContent(),
                'Date' => $value->getDate()->format('Y-m-d'),
                'Token' => $value->getToken(),
                'Answers' => array(),
            );
            $this->_user_cache[] = array('ID' => $value->getID(), 'Answers' => array());
        }
    }
   
    public function prepareArrayForUpdateAnswers($last_id, $server_cache)
    {
        
        $query = $this->_em->createQueryBuilder()->select('a')->from('MyTwitMyTwitBundle:Answers', 'a')
                ->where('a.id > :last_id')
                ->setParameter('last_id', $last_id);
        $answers = $query->getQuery()->getResult();
        
        foreach($answers as $key => $answer)
        { 
            $answer_for = $this->_returnTweetId($server_cache, $answer->getAnswersFor()->getID());
            $this->_tweets_array[$answer_for]['Answers'][] = array(
                'ID' => $answer->getID(),
                'Author' => $answer->getAuthor()->getNickname(),
                'Email' => $answer->getAuthor()->getEmail(),
                'Content' => $answer->getContent(),
                'Date' => $answer->getDate()->format('Y-m-d')
            );
            $this->_user_cache[$answer_for]['Answers'][] = $answer->getID();
        } 
        $this->_cache->updateUserCache($this->_user_cache);
        //$this->_cache->updateUserCache($ids_for_cache);
        return $this->_tweets_array;
    }
    
    protected function _returnTweetId($server_cache, $answerforid)
    {
        foreach($server_cache as $key => $value)
        {
            if($value['ID'] == $answerforid)
            {
                return $key;
            }
        }
    }
}    
?>
