<?php

namespace MyTwit\MyTwitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyTwit\MyTwitBundle\Forms\LoginForm;
use MyTwit\MyTwitBundle\Forms\RegisterForm;
use MyTwit\MyTwitBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;

class UnloggedUserController extends Controller
{
    
    /**
     * @Annotation Login Action
     * @return render(View, array(vars)
     */
    public function loginAction()
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            // redirect authenticated users to homepage
           return $this->redirect($this->generateUrl('home_after_login'));
        }
        $form = $this->createForm(new LoginForm());
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'MyTwitMyTwitBundle:Unlogged:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
                   'form' => $form->createView()
                )
            );
        
        return $this->render('MyTwitMyTwitBundle:Unlogged:login.html.twig', array('form' =>$form->createView()));
    }
    
    /**
     * @Annotation Register Action
     * @return render(View, array(vars)
     */
    public function registerAction()
    {
        $user = new User();
        $form = $this->createForm(new RegisterForm(), $user);
        
        // If form is sent
         
        if($this->getRequest()->isMethod('POST'))
        {
            // bind data to form
            $form->handleRequest($this->getRequest());
            //if form is valid
            if($form->isValid())
            {
                //get user helper
                $helper = $this->get('users_helper');
                
                //if user is not exist in DB
                if($helper->userExist($user->getNickname()) == false)
                {
                    //prepare data to save
                    $user->setPassword($helper->hashPassword($user->getPassword()));
                    $user->setToken($helper->hashPassword($user->getNickname()));
                    
                    //save user to DB
                    $helper->save($user);
                    
                    //prepare link
                    $link = '<a href=" ' . $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'] . '/activate/ ' . $user->getToken() . '"> ' . $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'] . '/activate/ ' . $user->getToken() . '</a>';
                    
                    //send mail with token
                    $mailer = $this->get('send_mail');
                    $mailer -> prepareMail('You registered on our site. MyTwit!', $user->getEmail(), 'You registered on our website. Go for this site<br /><a ' . $link . '<br />to active your account.');
                    $mailer -> sendMail();
                    
                    //return info
                    $this->get('session')->getFlashBag()->add('notice', 'Użytkownik został utworzony!');
                    
                    //redirect to login form
                    return $this->redirect($this->generateUrl('login'));
                }
                else
                {
                    //return info
                    $this->get('session')->getFlashBag()->add('notice', 'Użytkownik już istnieje!');
                }
            }
            else
            {
                //if form is not valid
                $this->get('session')->getFlashBag()->add('notice', 'Formularz jest niepoprawny!');
            }
        }
        return $this->render('MyTwitMyTwitBundle:Unlogged:register.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * Action for activate user
     * 
     * @param string $token Set token to activate
     * @return url Redirect to login form
     */
    public function activateAction($token)
    {
        //activate account
        $helper = $this->get('users_helper');
        $activate = $helper -> activateUser($token);
        
        //redirect to login form
        $this->get('session')->getFlashBag()->add('notice', $activate);
        return $this->redirect($this->generateUrl('login'));
    }
}
