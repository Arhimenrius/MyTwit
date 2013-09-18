<?php

namespace MyTwit\MyTwitBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;


/**
 * @Annotation Prepare form for config
 */
class ConfigForm extends AbstractType
{
    protected $_options;
    
    /**
     * 
     * @param array Set prepared options to config
     * @return array Get prepared options
     */
    public function __construct($options) {
        return $this->_options = $options;
    }

    /**
     * 
     * @param \Symfony\Component\Form\FormBuilderInterface $builder 
     * @param array $options Options to add
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $config = $this->_options;
        $options = $config->returnOptions();
        
        foreach($options as $option => $key)
        {
            if($key['Type'] != 'choice')
            {
                $builder -> add($key['Name'], $key['Type'], array('attr' => array(
                    'value' => $key['Value']),
                    'required' => $key['Required'],
                    'label' => $key['Label']
                ));
            }
            else
            {
                $builder-> add($key['Name'], $key['Type'], array(
                    'required' => $key['Required'], 
                    'choices' => $key['Value'],
                    'label' => $key['Label']
                ));
            }
        }
        
    }
    
    /**
     * 
     * @return string Return f  orm name
     */
    public function getName()
    {
        return 'Config';
    }
}

?>
