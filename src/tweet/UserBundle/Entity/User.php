<?php

namespace tweet\UserBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints as CaptchaAssert;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * User
 *
 * @ORM\Table(name="gig_user")
 * @ORM\Entity(repositoryClass="tweet\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser implements ParticipantInterface {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    
    

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255,nullable=true)
     */
    protected $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", length=255,nullable=true)
     */
    protected $googleId;

    
    /**
     * @var \tweet\UserBundle\Entity\User
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="tweet\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_add", referencedColumnName="id",nullable=true, onDelete="SET NULL")
     */
    private $userAdd;

    /**
     * @var \tweet\UserBundle\Entity\User
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="tweet\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_upd", referencedColumnName="id",nullable=true, onDelete="SET NULL")
     */
    private $userUpd;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="date_upd", type="datetime")
     */
    private $dateUpd;

    public function __construct() {
        parent::__construct();
        // your own logic
    }

    public function setEmail($email) {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

   
   
    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId) {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId() {
        return $this->facebookId;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId) {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId() {
        return $this->googleId;
    }

    /**
     * Set dateAdd
     *
     * @param \DateTime $dateAdd
     *
     * @return User
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateAdd
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * Set dateUpd
     *
     * @param \DateTime $dateUpd
     *
     * @return User
     */
    public function setDateUpd($dateUpd)
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    /**
     * Get dateUpd
     *
     * @return \DateTime
     */
    public function getDateUpd()
    {
        return $this->dateUpd;
    }

    /**
     * Set userAdd
     *
     * @param \tweet\UserBundle\Entity\User $userAdd
     *
     * @return User
     */
    public function setUserAdd(\tweet\UserBundle\Entity\User $userAdd = null)
    {
        $this->userAdd = $userAdd;

        return $this;
    }

    /**
     * Get userAdd
     *
     * @return \tweet\UserBundle\Entity\User
     */
    public function getUserAdd()
    {
        return $this->userAdd;
    }

    /**
     * Set userUpd
     *
     * @param \tweet\UserBundle\Entity\User $userUpd
     *
     * @return User
     */
    public function setUserUpd(\tweet\UserBundle\Entity\User $userUpd = null)
    {
        $this->userUpd = $userUpd;

        return $this;
    }

    /**
     * Get userUpd
     *
     * @return \tweet\UserBundle\Entity\User
     */
    public function getUserUpd()
    {
        return $this->userUpd;
    }
}
