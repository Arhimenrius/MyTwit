<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;
use MyTwit\MyTwitBundle\Entity\Tweets;
use MyTwit\MyTwitBundle\Entity\User;
use MyTwit\MyTwitBundle\Entity\Hashtags;
class HashtagHelper {
    protected $_em;
    protected $_security;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em Include database service
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, $security)
    {
        $this->_em = $em;
        $this->_security = $security;
    }
    
    public function handleHashtags(Tweets $tweet)
    {
        preg_match_all("/#(\w*[a-zA-Z_]+\w*)/i", $tweet->getContent(), $hashtags);
        $tweet->setHashtags($this->_prepareHashtag($hashtags));
        $tweet->setContent(preg_replace("/#(\w*[a-zA-Z0-9_]+\w*)/i", "<a href=\"http://".$_SERVER['HTTP_HOST']."".$_SERVER['SCRIPT_NAME']."/logged/tags/$1\">$0</a>", $tweet->getContent()));
        $tweet->setContent(preg_replace("/@(\w*[a-zA-Z0-9_]+\w*)/i", "<a href=\"http://".$_SERVER['HTTP_HOST']."".$_SERVER['SCRIPT_NAME']."/logged/profil/$1\">$0</a>", $tweet->getContent()));
    }
    
    protected function _prepareHashtag(array $hashtags)
    {
        $real_hashtags = array();
        $ids = '';
        if(!empty($hashtags[0]))
        {
            
            foreach($hashtags as $hashtag)
            {
                if($hashtag[0][0] == '#')
                {
                    $real_hashtags = $hashtag;
                }
            }
            $this->_addToHashtagsTable($real_hashtags);
            $ids = $this->_returnIdsOfHashtags($real_hashtags);
            $this->_addHashtagsToUser($ids);
        }
        return $ids;
    }
    
    protected function _addToHashtagsTable($hashtags)
    {
        $hashtags_entity = new Hashtags;
        
        foreach($hashtags as $hashtag)
        {
            $hashtags_entity = new Hashtags;
            $hashtags_entity->setName($hashtag);
            $tag = $this->_em->getRepository('MyTwitMyTwitBundle:Hashtags')->findBy(array('name' => $hashtag));
            if($tag == null)
            {
                $this->_em->persist($hashtags_entity);
            }
            $this->_em->flush();
            unset($hashtags_entity);
        }
    }
    
    protected function _returnIdsOfHashtags($hashtags)
    {
        $ids = '';
        foreach($hashtags as $hashtag)
        {
            $tag = $this->_em->getRepository('MyTwitMyTwitBundle:Hashtags')->findBy(array('name' => $hashtag));
            $ids .= $tag[0]->getId().',';
        }
        return $ids;
    }
    
    protected function _addHashtagsToUser($ids)
    {
        $ids = explode(',', $ids);
        array_pop($ids);
        $user = $this->_em->getRepository('MyTwitMyTwitBundle:User')->find($this->_security->getToken()->GetUser()->getID());
        $tags = $user->getHashtags();
        $merged_arrays = '';
        if($tags != null)
        {
            $tags = explode(',', $tags);
            array_pop($tags);
            $merged_arrays = array_merge($ids, $tags);
        }
        else
        {
            $merged_arrays = $ids;
        }
        $merged_arrays = array_unique($merged_arrays);
        $all_ids = '';
        foreach($merged_arrays as $id)
        {
            $all_ids .= $id.',';
        }
        $user->setHashtags($all_ids);
        $this->_em->flush();

    }
}

?>
