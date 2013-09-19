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
     * Get hashtags
     *
     * @return string 
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }
    /**
     * @var integer
     */
    private $answer_for;


    /**
     * Set answer_for
     *
     * @param integer $answerFor
     * @return Tweets
     */
    public function setAnswerFor($answerFor)
    {
        $this->answer_for = $answerFor;
    
        return $this;
    }

    /**
     * Get answer_for
     *
     * @return integer 
     */
    public function getAnswerFor()
    {
        return $this->answer_for;
    }
}