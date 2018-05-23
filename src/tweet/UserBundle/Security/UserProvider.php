<?php

namespace tweet\UserBundle\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProvider extends BaseClass {

    /**
     * Constructor.
     *
     * @param UserManagerInterface $userManager FOSUB user provider.
     * @param array                $properties  Property mapping.
     */
    public function __construct(UserManagerInterface $userManager, array $properties, $doctrine, $container) {
        $this->userManager = $userManager;
        $this->properties = array_merge($this->properties, $properties);
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->doctrine = $doctrine;
        $this->container = $container;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {

        $username = $response->getUsername();
        $data = $response->getResponse();
        $reflect = new \ReflectionClass($response->getResourceOwner());
        $className = $reflect->getShortName();
        $user = NULL;
        $source = null;

        switch ($response->getResourceOwner()->getName()) {
            case 'google':
                $user = $this->userManager->findUserBy(array('googleId' => $data['id']));
                if (null === $user) {
                    $user = $this->newGoogleUser($data);
                }
                break;
            case 'facebook':
                $user = $this->userManager->findUserBy(array('facebookId' => $data['id']));
                if (null === $user) {
                    $user = $this->userManager->findUserBy(array('email' => $data['email']));
                }
                if (null === $user) {
                    $user = $this->newFacebookUser($data);
                }
                break;
            default:
                break;
        }   
        //if user exists - go with the HWIOAuth way
      /*  $user = parent::loadUserByOAuthUserResponse($response);
        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';
        //update access token
        $user->$setter($response->getAccessToken());*/
        $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
        $this->container->get("security.context")->setToken($token); //now the user is logged in
        $this->container->get('session')->set('_security_secured_area', serialize($token));

        return $user;
    }

    private function newGoogleUser($data) {
        $em = $this->doctrine->getManager();
        $user = $this->userManager->createUser();
        $user->setUsername($data['id']);
        $user->setEmail($data['email']);
        $pass = uniqid();
        $user->setPassword($pass);
        $user->setFirstName($data['given_name']);
        $user->setLastName($data['family_name']);
        $user->setGoogleId($data['id']);
        $user->setEnabled(true);
        $this->userManager->updateUser($user);
        return $user;
    }

    private function newFacebookUser($data) {
        $em = $this->doctrine->getManager();
        $user = $this->userManager->createUser();
        $user->setUsername($data['id']);
        $user->setEmail($data['email']);
        $pass = uniqid();
        $user->setPassword($pass);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setGoogleId($data['id']);
        $user->setEnabled(true);
        $this->userManager->updateUser($user);
        return $user;
    }

}
