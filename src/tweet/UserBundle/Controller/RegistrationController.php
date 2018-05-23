<?php

namespace tweet\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as FOSRegistrationController;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\UserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use tweet\UserBundle\Entity\TrustMarker;
/**
 * Description of RegistrationController
 
 */
class RegistrationController extends FOSRegistrationController
{
    
    public function resendConfirmAction(Request $request)
    {
        
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('tweet.resend_confirm.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher  = $this->get('event_dispatcher');
        
        $user = $userManager->createUser();
        $form = $formFactory->createForm();
        $form->setData($user);
        
        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            
            if ($form->isValid()) {
                $email = $user->getEmail();
                $user  = $userManager->findUserByEmail($email);
                
                if (null === $user) {
                    return $this->render('UserBundle:Registration:resend_confirm.html.twig', array(
                        'form' => $form->createView(),
                        'invalid_username' => $email
                    ));
                }
                
                $event = new GetResponseUserEvent($user, $request);
                $dispatcher->dispatch(\tweet\UserBundle\UserEvents::REGISTRATION_RESEND, $event);
                $userManager->updateUser($user);
                
                if (null === $response = $event->getResponse()) {
                    $url      = $this->container->get('router')->generate('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }
                
                return $response;
            }
        }
        
        return $this->render('UserBundle:Registration:resend_confirm.html.twig', array(
            'form' => $form->createView()
        ));
    }
    public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher  = $this->get('event_dispatcher');
        
        $user = $userManager->createUser();
        $user->setEnabled(true);
        
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);
        
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        
        $form = $formFactory->createForm();
        $form->setData($user);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
            
            $userManager->updateUser($user);
            
            if (null === $response = $event->getResponse()) {
                $url      = $this->generateUrl('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }
            
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
            
            return $response;
            
        }
        
        return $this->render('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
