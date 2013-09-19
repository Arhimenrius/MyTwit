<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;

use MyTwit\MyTwitBundle\Entity\Tweets;

class TweetsHelper
{
    protected $_em;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em Include database service
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->_em = $em;
    }
    
    
    /**
     * Method for save new users data
     * 
     * @param \MyTwit\MyTwitBundle\Entity\User $user Set user data
     */
    
    public function save(Tweets $tweet) {
        if(!$tweet->getId())
        {
            $this->_em->persist($tweet);
        }
        $this->_em->flush();     
    }

}

?>
