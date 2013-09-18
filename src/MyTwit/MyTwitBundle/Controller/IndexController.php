<?php

namespace MyTwit\MyTwitBundle\Controller;

use MyTwit\MyTwitBundle\Forms\ConfigForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function homeAction()
    {
        return $this->render('MyTwitMyTwitBundle:Index:home.html.twig');
    }
    
    public function configAction()
    {
        $helper = $this->get('config_helper');
        $form = $this->createForm(new ConfigForm($helper));
        if($this->getRequest()->isMethod('POST'))
        {
            $form->handleRequest($this->getRequest());
            $data = $form->getData();
            if($form->isValid())
            {
                $helper->save($data);
                $this->get('session')->getFlashBag()->add('notice', 'Ustawienia zmienione!');
        
                return $this->redirect($this->generateUrl('config'));
            }
        }
        return $this->render('MyTwitMyTwitBundle:Config:config.html.twig', array('form' => $form->createView()));
    }
}
