<?php

namespace tweet\UserBundle\Security;

use Symfony\Component\Security\Core\Exception\CredentialsExpiredException;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FOS\MessageBundle\Provider\ProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * UserChecker checks the user account flags.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class UserChecker implements UserCheckerInterface {

    private $session;
    private $container;
    public function __construct($session) {
        $this->session = $session;
        
    }

    public function checkPreAuth(UserInterface $user) {
        if (!$user instanceof AdvancedUserInterface) {
            return;
        }




        if (!$user->isEnabled()) {
         echo 'your account not activated yet , please check your mail or click resend activation mail <br><a href="register/resend-confirm">resend activation mail</a>';
         die;
            if ($user->getUserUpd()) {
                $ex = new CustomUserMessageAuthenticationException('User account is disabled.contact admin');
              //  $ex->setUser($user);
                throw $ex;
            } else {
                $ex = new DisabledException('User account is disabled.');
                $ex->setUser($user);
                throw $ex;
            }
        }

        if (!$user->isAccountNonExpired()) {
            $ex = new AccountExpiredException('User account has expired.');
            $ex->setUser($user);
            throw $ex;
        }
    }

    public function checkPostAuth(UserInterface $user) {
        if (!$user instanceof AdvancedUserInterface) {
            return;
        }

        if (!$user->isCredentialsNonExpired()) {
            $ex = new CredentialsExpiredException('User credentials have expired.');
            $ex->setUser($user);
            throw $ex;
        }
        if (!$user->isAccountNonLocked()) {
            $this->session->set('blockeduserid', $user->getId());
            $ex = new LockedException('User account is locked.');
            $ex->setUser($user);
            throw $ex;
        }
    }

}
