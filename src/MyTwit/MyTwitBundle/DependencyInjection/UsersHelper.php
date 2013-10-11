<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;

use MyTwit\MyTwitBundle\Entity\User;

class UsersHelper
{
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
    
    /**
     * Return data of user how array.
     * 
     * @param string $username Nickname of user
     * @return array Return all data of user
     */
    public function returnUserData($username)
    {
        $user = $this->_em->getRepository('MyTwitMyTwitBundle:User')->findBy(array('nickname'=>$username));
        $user_data = array(
            'Id' => $user[0]->getId(),
            'Nickname' => $user[0]->getNickname(),
            'Email' => $user[0]->getEmail(),
            'Avatar' => $user[0]->getAvatar(),
        );
        return $user_data;
    }
    
    public function returnObservedArray($observed)
    {
        $observed_user = explode(',', $observed);
        array_pop($observed_user);
        return $observed_user;
    }
    
    public function changeObserved($data)
    {
        $user = $this->_em->getRepository('MyTwitMyTwitBundle:User')->find($this->_security->getToken()->getUser()->getID());
        $observed = $this->returnObservedArray($user->getObserved());
        if($data->change == 'add')
        {
            $key = '';
            $key = array_search((int)$data->id, $observed);
            if($key != '')
            {
                unset($observed[$key]);
            }
            if((int)$data->id != 0)
                $observed[] = (int)$data->id;
        }
        else
        {
            $key = '';
            $key = array_search((int)$data->id, $observed);
            if($key != '')
            {
                unset($observed[$key]);
            }
        }
        $observed_to_db = '';
        foreach($observed as $obs)
        {
            $observed_to_db .= $obs.',';
        }
        $user->setObserved($observed_to_db);
        $this->_em->flush();
    }
    
    public function returnObservedUsers()
    {
        $user = $this->_em->getRepository('MyTwitMyTwitBundle:User')->find($this->_security->getToken()->getUser()->getID());
        $observed = $this->returnObservedArray($user->getObserved());
        return $observed;
    }
    
    public function searchUserOfTheId($ids)
    {
        $query = $this->_em->createQueryBuilder()->select('u')->from('MyTwitMyTwitBundle:User', 'u');
        $where = 'u.id IN (';
        foreach($ids as $id)
        { 
            $where .= $id.',';
        }
        $where = substr($where, 0, -1);
        $where .= ')';
        $query->where($where);
        $users = $query->getQuery()->getResult();
        
        $user_data = array();
        foreach($users as $key => $user)
        {
           $user_data[] = array(
            'Id' => $user->getId(),
            'Nickname' => $user->getNickname(),
            'Email' => $user->getEmail(),
            'Avatar' => $user->getAvatar(),
        ); 
        }
        return $user_data;
    }
}

?>
