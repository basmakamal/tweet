<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tweet\UserBundle\Security;

/**
 * Description of CustomSecurity
 *
 */
class CustomSecurity {

    private $container;
    private $security;
    private $doctrine;
    private $package = false;
    public function __construct($container, $security, $doctrine) {
        $this->container = $container;
        $this->security = $security;
        $this->doctrine = $doctrine;
    }

    public function getToken() {
        return $this->security->getToken();
    }

    public function getUser() {

        if ($this->security->getToken()->getUser() && $this->isGranted('ROLE_USER')) {

            $user = $this->doctrine->getRepository('UserBundle:User')->find($this->security->getToken()->getUser()->getId());
            return $user;
        } else {
            return false;
        }
    }
    public function getPackage($user)
    {

        if ($user->getType() == 'talent') {
            $memebership = $this->doctrine->getRepository('AppBundle:MembershipHistory')->getCurrentPackage($user->getTalent()->getId());

            if($memebership){
                return $memebership->getMembershipType();
            }

        }
        return false;
    }
    public function isGranted($attributes, $object = null) {
        return $this->security->isGranted($attributes, $object);
    }

}
