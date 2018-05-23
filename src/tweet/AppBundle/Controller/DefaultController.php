<?php

namespace tweet\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\FeedRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller {

    /**
     * @Route("/", name="home_page",options={"expose": "true"})
     */
    public function indexAction() { 
        return $this->render('AppBundle:Default:index.html.twig');
    }
    /**
     * @Route("/", name="add_tweet",options={"expose": "true"})
     */
    public function addTweetAction(Request $request) {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedHttpException;
        }
        if (!$this->get('custom_security')->getUser()) {
            throw new AccessDeniedHttpException;
        }
        $form = $this->createForm(new TweetFormType(null, null, $this->get('service_container')));
        $form->submit($request->get('user_tweet'));

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tweet = $form->getData(); 
            $em->persist($tweet);
            $em->flush();          
            return new RedirectResponse($this->container->get('router')->generate('home_page'));
            }
       
       
    }
		/**
     * @Route("/", name="like_tweet",options={"expose": "true"})
     */
    public function tweetLikeAction(Request $request) {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedHttpException;
        }
        if (!$this->get('custom_security')->getUser()) {
            throw new AccessDeniedHttpException;
        }
        $id = $request->get('id');
        $curentUser = $this->get('custom_security')->getUser();
        $usertweets = $this->getDoctrine()->getRepository('TweetsBundle:UserTweets')->find($id);
        $tweetLike = new \tweet\TweetsBundle\Entity\UserTweetsLike;
        $tweetLike->setUser($curentUser);
        $tweetLike->setUserTweets($usertweets);
        $em = $this->getDoctrine()->getManager();      
        $em->persist($tweetLike);
        $em->flush();
        return new JsonResponse(array(
            'success' => false
        ));
    }
}