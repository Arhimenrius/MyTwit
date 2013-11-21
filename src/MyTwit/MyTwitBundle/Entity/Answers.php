<?php

namespace MyTwit\MyTwitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answers
 */
class Answers
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $answerFor;

    /**
     * @var string
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
     * @param string $author
     * @return Answers
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Answers
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
     * @return Answers
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
     * @return Answers
     */
    public function setHashtags($hashtags)
    {
        $this->hashtags = $hashtags;
    
        return $this;
    }

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
     * @var \MyTwit\MyTwitBundle\Entity\Tweets
     */
    protected $answersFor;


    /**
     * Set answersFor
     *
     * @param \MyTwit\MyTwitBundle\Entity\Tweets $answersFor
     * @return Answers
     */
    public function setAnswersFor(\MyTwit\MyTwitBundle\Entity\Tweets $answersFor = null)
    {
        $this->answersFor = $answersFor;
    
        return $this;
    }

    /**
     * Get answersFor
     *
     * @return \MyTwit\MyTwitBundle\Entity\Tweets 
     */
    public function getAnswersFor()
    {
        return $this->answersFor;
    }
}