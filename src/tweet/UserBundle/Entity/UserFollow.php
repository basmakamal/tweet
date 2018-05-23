<?php

namespace tweet\UserBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserFollow
 *
 * @ORM\Table(name="user_follow")
 * @ORM\Entity(repositoryClass="tweet\UserBundle\Repository\UserFollowRepository")
 */
class UserFollow
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \tweet\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\tweet\UserBundle\Entity\User", cascade={"persist"})
     */
    private $user;

    /**
     * @var \tweet\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="tweet\UserBundle\Entity\User", cascade={"persist"})
     */
    private $user_follow;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $dateAdd
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * @param \tweet\UserBundle\Entity\User $user
     */
    public function setuserfollow($user_follow)
    {
        $this->userfollow = $user_follow;
    }

    /**
     * @return \tweet\UserBundle\Entity\User
     */
    public function getuserfollow()
    {
        return $this->user_follow;
    }

    /**
     * @param \tweet\UserBundle\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \tweet\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
