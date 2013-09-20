<?php

namespace MyTwit\MyTwitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tweets
 */
class Tweets
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $author;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected $hashtags;

    
     public function __construct()
     {
         $this->answersFor = new ArrayCollection();  
     }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param integer $author
     * @return Tweets
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return integer 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Tweets
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Tweets
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set hashtags
     *
     * @param string $hashtags
     * @return Tweets
     */
    public function setHashtags($hashtags)
    {
        $this->hashtags = $hashtags;
    
        return $this;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $answersFor;


    /**
     * Get hashtags
     *
     * @return string 
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }

    /**
     * Add answersFor
     *
     * @param \MyTwit\MyTwitBundle\Entity\Answers $answersFor
     * @return Tweets
     */
    public function addAnswersFor(\MyTwit\MyTwitBundle\Entity\Answers $answersFor)
    {
        $this->answersFor[] = $answersFor;
    
        return $this;
    }

    /**
     * Remove answersFor
     *
     * @param \MyTwit\MyTwitBundle\Entity\Answers $answersFor
     */
    public function removeAnswersFor(\MyTwit\MyTwitBundle\Entity\Answers $answersFor)
    {
        $this->answersFor->removeElement($answersFor);
    }

    /**
     * Get answersFor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswersFor()
    {
        return $this->answersFor;
    }
}