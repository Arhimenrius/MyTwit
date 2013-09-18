<?php

namespace MyTwit\MyTwitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function homeAction()
    {
        return $this->render('MyTwitMyTwitBundle:Index:home.html.twig');
    }
}
