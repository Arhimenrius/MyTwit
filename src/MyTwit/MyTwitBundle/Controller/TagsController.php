<?php

namespace MyTwit\MyTwitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class TagsController extends Controller
{
    public function tagsAction($name = '0')
    {
        return $this->render('MyTwitMyTwitBundle:Index:tags.html.twig');
    }
}
?>
