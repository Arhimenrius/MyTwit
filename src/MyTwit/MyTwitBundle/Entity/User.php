<?php

namespace MyTwit\MyTwitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $nickname;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $avatar;

    /**
     * @var boolean
     */
    protected $switched;

    /**
     * @var string
     */
    protected $token;
    
    protected $tweets;


     public function __construct()
     {
         $this->tweets = new ArrayCollection();  
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
     * Set nickname
     *
     * @param string $nickname
     * @return User
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    
        return $this;
    }

    /**
     * Get nickname
     *
     * @return string 
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    
        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set switched
     *
     * @param boolean $switched
     * @return User
     */
    public function setSwitched($switched)
    {
        $this->switched = $switched;
    
        return $this;
    }

    /**
     * Get switched
     *
     * @return boolean 
     */
    public function getSwitched()
    {
        return $this->switched;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }
    /**
     * @var string
     */
    protected $observed;

    /**
     * @var string
     */
    protected $hashtags;


    /**
     * Set observed
     *
     * @param string $observed
     * @return User
     */
    public function setObserved($observed)
    {
        $this->observed = $observed;
    
        return $this;
    }

    /**
     * Get observed
     *
     * @return string 
     */
    public function getObserved()
    {
        return $this->observed;
    }

    /**
     * Set hashtags
     *
     * @param string $hashtags
     * @return User
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
     * @var string
     */
    protected $role;


    /**
     * Set role
     *
     * @param string $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }
    
    public function getRoles() {
        if($this->role == 'admin')
        {
            return array('ROLE_ADMIN');
        }
        elseif($this->role == 'user')
        {
            return array('ROLE_USER');
        }
    }
    
    public function getSalt() {
        
    }
    
    public function getUsername() {
        return $this->nickname;
    }
    
    public function eraseCredentials() {
    }
    
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }
    
    public function unserialize($serialized) {
        list ($this->id) = unserialize($serialized);
    }
    
    public function addTweet(\MyTwit\MyTwitBundle\Entity\Tweets $tweets)
    {
        $this->tweets[] = $tweets;
    
        return $this;
    }

    /**
     * Remove tweets
     *
     * @param \MyTwit\MyTwitBundle\Entity\Tweets $tweets
     */
    public function removeTweet(\MyTwit\MyTwitBundle\Entity\Tweets $tweets)
    {
        $this->tweets->removeElement($tweets);
    }

    /**
     * Get tweets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTweets()
    {
        return $this->tweets;
    }
    
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $answers;


    /**
     * Add answers
     *
     * @param \MyTwit\MyTwitBundle\Entity\Answers $answers
     * @return User
     */
    public function addAnswer(\MyTwit\MyTwitBundle\Entity\Answers $answers)
    {
        $this->answers[] = $answers;
    
        return $this;
    }

    /**
     * Remove answers
     *
     * @param \MyTwit\MyTwitBundle\Entity\Answers $answers
     */
    public function removeAnswer(\MyTwit\MyTwitBundle\Entity\Answers $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnswers()
    {
        return $this->answers;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $answersFor;


    /**
     * Add answersFor
     *
     * @param \MyTwit\MyTwitBundle\Entity\Answers $answersFor
     * @return User
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