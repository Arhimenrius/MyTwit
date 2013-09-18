<?php

namespace MyTwit\MyTwitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyTwit\MyTwitBundle\Forms\LoginForm;
use MyTwit\MyTwitBundle\Forms\RegisterForm;

class UnloggedUserController extends Controller
{
    
    /**
     * @Annotation Login Action
     * @return render(View, array(vars)
     */
    public function loginAction()
    {
        $form = $this->createForm(new LoginForm());
        
        return $this->render('MyTwitMyTwitBundle:Unlogged:login.html.twig', array('form' =>$form->createView()));
    }
    
    /**
     * @Annotation Register Action
     * @return render(View, array(vars)
     */
    public function registerAction()
    {
        $form = $this->createForm(new RegisterForm());
        
        return $this->render('MyTwitMyTwitBundle:Unlogged:register.html.twig', array('form' => $form->createView()));
    }
}
