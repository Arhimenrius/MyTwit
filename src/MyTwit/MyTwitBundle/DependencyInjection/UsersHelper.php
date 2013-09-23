<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;

use MyTwit\MyTwitBundle\Entity\User;

class UsersHelper
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
     * Method for hashing password
     *  
     * @param string $password Set password to hash
     * @return string Return hashed password
     */
    public function hashPassword($password)
    {
        if (CRYPT_SHA512 == 1) {
            $password = hash('sha512', $password);
        }
        else
        {
            $password = hash('md5', $password);
        }
        return $password;
    }
    
    /**
     * Looking for users in database
     * 
     * @param string $nickname Nickname of user 
     * @return boolean
     */
    public function userExist($nickname)
    {
        $query = $this->_em->getRepository('MyTwitMyTwitBundle:User')->findBy(array('nickname' => $nickname));
        if($query)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Method for save new users data
     * 
     * @param \MyTwit\MyTwitBundle\Entity\User $user Set user data
     */
    
    public function save(User $user) {
        if(!$user->getId())
        {
            $user->setAvatar('none.png');
            $user->setRole('user');
            $user->setSwitched('1');
            $this->_em->persist($user);
        }
        $this->_em->flush();     
    }
    
    
    /**
     * Method for activate user
     * 
     * @param string $token
     * @return string
     */
    public function activateUser($token)
    {
        $token = substr($token, 1);
        $query = $this->_em->getRepository('MyTwitMyTwitBundle:User')->findOneBy(array('token' => $token));
        if($query)
        {
            $query->setToken('1');
            $query->setIs_Active(1);
            $this->_em->flush();
            return 'Użytkownik został zaaktywowany';
        }
        else
        {
            return 'Nie ma takiego użytkownika lub już jest zaaktywowany';
        }
    }
}

?>
