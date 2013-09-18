<?php

namespace MyTwit\MyTwitBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @author Andrzej Wojtyś
 * 
 * @Annotation Prepare form to register
 */

class RegisterForm extends AbstractType
{   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Nickname', 'text', array(
            'label' => 'Podaj nazwę użytkownika' ,
            'constraints' => array(
                new Length(array('max' => 255)),
                new Email())));
        
        $builder->add('Password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'Hasła się nie zgadzają',
            'required' => true,
            'first_options' => array('label' => 'Podaj hasło'),
            'second_options' => array('label' => 'Powtórz hasło'),
        ));
        
        $builder->add('Email', 'repeated', array(
            'type' => 'text',
            'invalid_message' => 'E-maile się nie zgadzają',
            'required' => true,
            'first_options' => array('label' => 'Podaj e-mail'),
            'second_options' => array('label' => 'Powtórz e-mail'),
            'constraints' => array(
                new Length(array('max' => 255)),
                new Email(),
        )));
        
        $builder->add('Submit', 'submit');
    }

    /**
     * 
     * @return string Return Form name
     * 
     */
    
    public function getName()
    {
        return 'register';
    }
}

?>
