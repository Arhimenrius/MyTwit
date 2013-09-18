<?php

namespace MyTwit\MyTwitBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Andrzej Wojtyś
 * 
 * @Annotation Prepare form to login
 */

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('_username', 'text', array('label' => 'Podaj nazwę użytkownika'));
        $builder->add('_password', 'password', array('label' => 'Podaj hasło'));
        $builder->add('Submit', 'submit');
        $builder ->setAction('login_check');
        $builder ->setMethod('post');
    }

    public function getName()
    {
    }
}

?>
