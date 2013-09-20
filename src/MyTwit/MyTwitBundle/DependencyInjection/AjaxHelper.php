<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;

/**
 * Class for prepare data for AJAX
 */
class AjaxHelper
{
    protected $_em;
    protected $_cache;
    
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
    public function prepareArrayFromAllTweets()
    {
       $tweets = $this->_em->getRepository('MyTwitMyTwitBundle:Tweets')->findAll(); 
       $answers = $this->_em->getRepository('MyTwitMyTwitBundle:Answers')->findAll(); 
      
       foreach($tweets as $key => $value)
        {
            $all_data[$key] = array(
                'ID' => $value->getID(),
                'Author' => $value->getAuthor()->getNickname(),
                'Email' => $value->getAuthor()->getEmail(),
                'Content' => $value->getContent(),
                'Date' => $value->getDate()->format('Y-m-d'),
                    );
        }
        $this->_cache->createUserCache($tweets, $answers);
        return $all_data;
    }
    
    public function prepareArrayForUpdateTweets($last_id)
    {
        $tweets = $this->_em->createQuery("SELECT t FROM MyTwitMyTwitBundle:Tweets t WHERE t.id > $last_id ");
        return $tweets->getResult();
    }
}    

?>
