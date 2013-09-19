<?php
namespace MyTwit\MyTwitBundle\DependencyInjection;

/**
 * @Annotation Helper to secure 
 */

class SecurityHelper
{
    protected $_em;
    protected $_security;
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em include access to DB
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, \Symfony\Component\Security\Core\SecurityContext $security)
    {
        $this->_em = $em;
        $this->_security = $security;
    }
    
    /**
     * 
     * @return boolean If true, user is logged, so redirect him!
     */
    public function onlyUnlogged()
    {
        if ($this->_security->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            // redirect authenticated users to homepage
           return true;
        }
    }
}

?>
