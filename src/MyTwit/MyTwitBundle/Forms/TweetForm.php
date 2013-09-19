<?php

namespace MyTwit\MyTwitBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;


/**
 * @Annotation Prepare form for add tweet
 */
class TweetForm extends AbstractType
{
    /**
     * Return form
     * 
     * @param \Symfony\Component\Form\FormBuilderInterface $builder 
     * @param array $options Options to add
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('Tweet', 'textarea', array(
            'label' => 'Napisz coś...',
            'required' => false,
            'max_length' => 255,
            'attr' => array(
                'cols' => '34',
                'ng-model' => 'content',
                'ng-change' => 'numberOfChars(content)',
                'ng-focus' => 'changeRows(\'f\', content)',
                'ng-blur' => 'changeRows(\'b\', content)',
            )
        ));
        
        $builder->add('Answer', 'hidden');
    }
    
    /**
     * 
     * @return string Return form name
     */
    public function getName()
    {
        return 'Tweet';
    }
}

?>
