<?php

namespace tweet\TweetsBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserTweetsLike
 *
 * @ORM\Table(name="user_tweets_like")
 * @ORM\Entity(repositoryClass="tweet\TweetsBundle\Repository\UserTweetsLikeRepository")
 */
class UserTweetsLike
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
     * @var tweet\TweetsBundle\Entity\UserTweets
     *
     * @ORM\ManyToOne(targetEntity="tweet\TweetsBundle\Entity\UserTweets", cascade={"persist"})
     */
    private $user_tweets;

    /**
     * @var \tweet\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="tweet\UserBundle\Entity\User", cascade={"persist"})
     */
    private $user;

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
     * @param tweet\TweetsBundle\Entity\UserTweets $UserTweets
     */
    public function setUserTweets($user_tweets)
    {
        $this->user_tweets = $user_tweets;
    }

    /**
     * @return \tweet\TweetsBundle\Entity\UserTweets
     */
    public function getUserTweets()
    {
        return $this->user_tweets;
    }

    /**
     * @param \tweets\UserBundle\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \tweets\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
