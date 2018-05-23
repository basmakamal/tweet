<?php

namespace tweet\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Gregwar\CaptchaBundle\Type\CaptchaType;
class RegisterFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->remove('username');
        $builder->add('firstName', null, array('required' => true,'extra_fields_message' => 'Here some help text!!!'));
        $builder->add('lastName', null, array('required' => true));
        /**   Check if new
          if ($builder->getData()->isNew()) { // or !getId()
          $builder->add('delete', 'checkbox'); // or whatever
          } */
        
    }

    public function getParent() {
        return 'fos_user_registration';
    }

    public function getName() {
        return 'tweet_user_registration';
    }

}
