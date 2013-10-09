<?php

namespace MyTwit\MyTwitBundle\Controller;

use MyTwit\MyTwitBundle\Forms\ConfigForm;
use MyTwit\MyTwitBundle\Forms\TweetForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MyTwit\MyTwitBundle\Entity\Tweets;
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
