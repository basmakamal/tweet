<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace tweet\UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\ChangePasswordController as baseclass;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
/**
 * Controller managing the password change
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ChangePasswordController extends baseclass
{
    /**
     * Change user password
     */
    public function changePasswordAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
		$cookies = $request->cookies;
		$response = new Response();

        $session = new Session();
		if(!$cookies->has('secaccess')){
			$formCheckFactory = $this->get('tweet.checkpassword.form.factory');
			$form = $formCheckFactory->createForm();
			$form->handleRequest($request);
			if ($form->isValid()) {
				$response->headers->setCookie(new Cookie('secaccess', 'value', time() +	(3600 * 24)));
			}else{
				$response->setContent($this->renderView('UserBundle:ChangePassword:checkPassword.html.twig', array(
					'form' => $form->createView()
				)));
				return $response;		
			}
		}

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('tweet.change_password.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);
        $formDeactive = $this->createFormBuilder()
            ->add('disactive', 'submit', array('label' => 'Disactive account'))
            ->getForm();
		$formDeactive->handleRequest($request);	
        $form->handleRequest($request);
 
        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }
        if ($formDeactive->isValid()) {
		   $user->setLocked(true);
           $userManager = $this->get('fos_user.user_manager');
		   $userManager->updateUser($user);
		   $url = $this->generateUrl('fos_user_security_logout');
		   $response = new RedirectResponse($url);	
           return $response;		   
        }
		$response->setContent($this->renderView('UserBundle:ChangePassword:changePassword.html.twig', array(
            'form' => $form->createView(),
			'disactiveform'=>$formDeactive->createView()
        )));		
		return $response;

    }
	public function unlockAction(Request $request)
    {
		$session = $this->get('session');
		if($session->get('blockeduserid')){
			$um = $this->get('fos_user.user_manager');
			$user = $um->findUserBy(array('id'=>$session->get('blockeduserid')));
		    $user->setLocked(false);
            $um->updateUser($user);			
			$token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
			$this->get("security.context")->setToken($token); //now the user is logged in
			 
			//now dispatch the login event
			$request = $this->get("request");
			$event = new InteractiveLoginEvent($request, $token);
			$this->get("event_dispatcher")->dispatch("security.interactive_login", $event);	
            $url = $this->generateUrl('home_page');
            $response = new RedirectResponse($url);	
            return $response;				
		}
	}
}
