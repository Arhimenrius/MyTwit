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
        $ids = array();
        foreach($tweets as $key => $value)
        {
            $ids[] = $value->getID();
            $all_data[$key] = array(
                'ID' => $value->getID(),
                'Author' => $value->getAuthor()->getNickname(),
                'Email' => $value->getAuthor()->getEmail(),
                'Content' => $value->getContent(),
                'Date' => $value->getDate()->format('Y-m-d'),
            );
        }
        $this->_cache->updateUserCache($ids);
        return $all_data;
    }
}    


?>
