<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;

use MyTwit\MyTwitBundle\Entity\Tweets;

class TweetsHelper
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
        $this->_hashtag->handleHashtags($tweet);
        if(!$tweet->getId())
        {
            $this->_em->persist($tweet);
        }
        $this->_em->flush();  
        $this->_cache->updateTweetsCache($tweet->getId());
    }
    
    public function returnTweetsOfUser($username)
    {
        $user = $this->_em->getRepository('MyTwitMyTwitBundle:User')->findBy(array('nickname'=>$username));
        $user_id = $user[0]->getId();
        
        $tweets = $this->_em->getRepository('MyTwitMyTwitBundle:Tweets')->findBy(array('author' => $user_id));
        
        return $this->_returnArrayFromData($tweets);
    }
    
    public function returnTweetsAboutUser()
    {
        $username = '@'.$this->_security->getToken()->getUser()->getNickname();
        $query = $this
                ->_em
                ->createQueryBuilder()
                ->select('t')
                ->from('MyTwitMyTwitBundle:Tweets', 't')
                ->where('t.content LIKE :username')
                ->setParameter('username', '%'.$username.'%');
        $tweets = $query->getQuery()->getResult();
        
        return $this->_returnArrayFromData($tweets);
        
    }
    
    /**
     * Prepare array from Database
     * @param object $data Array with object from Database
     */
    protected function _returnArrayFromData($data)
    {
        $all_data = array();
        foreach($data as $key => $value)
        {
            $all_data[$key] = array(
                'ID' => $value->getID(),
                'Author' => $value->getAuthor()->getNickname(),
                'Email' => $value->getAuthor()->getEmail(),
                'Content' => $value->getContent(),
                'Date' => $value->getDate()->format('Y-m-d'),
            );
        }
        return $all_data;
    }
    
    public function returnTweetsFromAllUserTags()
    {
        $hashtags = $this->_security->getToken()->getUser()->getHashtags();
        $query = $this->_em->createQueryBuilder()->select('t')->from('MyTwitMyTwitBundle:Tweets', 't');
        $where = 't.id IN (';
        $where .= $hashtags;
        $where = substr($where, 0, -1);
        $where .= ')';
        $query->where($where);
        return $query->getQuery()->getResult();
    }
}
?>
