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
        $builder->add('Nickname', 'text', array('label' => 'Podaj nazwę użytkownika'));
        $builder->add('Password', 'password', array('label' => 'Podaj hasło'));
        $builder->add('Submit', 'submit');
    }

    public function getName()
    {
        return 'login';
    }
}

?>
