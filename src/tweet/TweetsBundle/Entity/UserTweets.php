<?php

namespace tweet\TweetsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserTweets
 * @ORM\Table(name="user_tweets")
 * @ORM\Entity(repositoryClass="tweet\TweetsBundle\Repository\UserTweetsRepository")
 */
class UserTweets {

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
     * @ORM\ManyToOne(targetEntity="tweet\UserBundle\Entity\User", cascade={"persist"})
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

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

    /**
     * @ORM\OneToMany(targetEntity="UserTweetsLike", mappedBy="user_tweets", cascade={"all"})
     */
    private $likes;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set body
     *
     * @param string $body
     */
    public function setBody($body) {
        $this->body = $body;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param \DateTime $dateAdd
     */
    public function setDateAdd($dateAdd) {
        $this->dateAdd = $dateAdd;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdd() {
        return $this->dateAdd;
    }

    /**
     * @param \DateTime $dateUpd
     */
    public function setDateUpd($dateUpd) {
        $this->dateUpd = $dateUpd;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpd() {
        return $this->dateUpd;
    }

    
    /**
     * @param \tweets\UserBundle\Entity\User $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return \tweets\UserBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->likes = new ArrayCollection();
    }

    /**
     * Add like
     *
     * @param \tweets\TweetsBundle\Entity\UserTweetsLike $like
     *
     * @return UserTweets
     */
    public function addLike(\tweets\TweetsBundle\Entity\UserTweetsLike $like) {
        $this->likes[] = $like;

        return $this;
    }

    /**
     * Remove like
     *
     * @param \tweets\TweetsBundle\Entity\UserTweetsLike $like
     */
    public function removeLike(\tweets\TweetsBundle\Entity\UserTweetsLike $like) {
        $this->likes->removeElement($like);
    }

    /**
     * Get likes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLikes() {
        return $this->likes;
    }

}
