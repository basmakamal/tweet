<?php

namespace tweet\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/user")
     */
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }
	
	/**
     * @Route("/", name="follow_user",options={"expose": "true"})
     */
    public function user_followAction(Request $request) {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedHttpException;
        }
        if (!$this->get('custom_security')->getUser()) {
            throw new AccessDeniedHttpException;
        }
        $id = $request->get('id');
        $curentUser = $this->get('custom_security')->getUser();
        $userfollow = $this->getDoctrine()->getRepository('UserBundle:User')->find($id);
        $user_follow_entity = new \tweet\UserBundle\Entity\UserFollow;
        $user_follow_entity->setUser($curentUser);
        $user_follow_entity->setUserFollow($userfollow);
        $em = $this->getDoctrine()->getManager();      
        $em->persist($user_follow_entity);
        $em->flush();
        return new JsonResponse(array(
            'success' => false
        ));
    }
}
