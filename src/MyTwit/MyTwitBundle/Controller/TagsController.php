<?php

namespace MyTwit\MyTwitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class TagsController extends Controller
{
    public function tagsAction($name = 'gt$rgBdSA$7*9,<cxzaeersaazz')
    {
        if($name == 'gt$rgBdSA$7*9,<cxzaeersaazz')
        {
            $tweets = $this->get('tweets_helper')->returnTweetsFromAllUserTags();
        }
        else
        {
            
        }
        return $this->render('MyTwitMyTwitBundle:Index:tags.html.twig');
    }
}
?>
