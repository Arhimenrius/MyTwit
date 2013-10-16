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
            $all_data[] = array(
                'ID' => $value->getID(),
                'Author' => $value->getAuthor()->getNickname(),
                'Email' => $value->getAuthor()->getEmail(),
                'Content' => $value->getContent(),
                'Date' => $value->getDate()->format('Y-m-d'),
                'Token' => $value->getToken(),
                'Answers' => array(),
            );
            $id_cache[] = $value->getID();
        }
        $all_data = $this->_prepareArrayForUpdateAnswers($id_cache, $all_data, $ids);
        return $all_data;
    }
    
    protected function _prepareArrayForUpdateAnswers($ids_for_cache, $data, $ids)
    {
        
        $query = $this->_em->createQueryBuilder()->select('a')->from('MyTwitMyTwitBundle:Answers', 'a');
        
        $query->where($this->_createQuery($data));
        $answers = $query->getQuery()->getResult();
        //looking for ids for tweets where i must add answers
        foreach($answers as $key => $answer)
        { 
            $answer_for = array_keys($ids, $answer->getAnswersFor()->getID());
            $data[$answer_for[0]]['Answers'][] = array(
                'ID' => $answer->getID(),
                'Author' => $answer->getAuthor()->getNickname(),
                'Email' => $answer->getAuthor()->getEmail(),
                'Content' => $answer->getContent(),
                'Date' => $answer->getDate()->format('Y-m-d')
            );
        }
        $this->_cache->updateUserCache($ids_for_cache);
        return $data;
    }
    
    protected function _createQuery($data)
    {
        $where = 'a.answersFor IN (';
        foreach($data as $key => $value)
        {
            $where .= $value['ID'] . ',';
        }
        $where = substr($where, 0, -1);
        $where .= ')';
        return $where;
    }
}    


?>
