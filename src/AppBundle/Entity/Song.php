<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Song
 *
 * @ORM\Table(name="song")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SongRepository")
 */
class Song
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @Groups({"song"})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Groups({"song"})
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @Groups({"song"})
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var string
     * @Groups({"song"})
     * @ORM\Column(name="photo", type="string", length=500, nullable=true)
     */
    private $photo;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @var User
     * @Groups({"song", "auth-token", "user"})
     */
    private $artist;

    /**
     * @var bool
     * @Groups({"song"})
     * @ORM\Column(name="explicit_content", type="boolean")
     */
    private $explicitContent;

    /**
     * @var bool
     * @Groups({"song"})
     * @ORM\Column(name="download_authorization", type="boolean")
     */
    private $downloadAuthorization;

    /**
     * @var \DateTime
     * @Groups({"song"})
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Groups({"song"})
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var int
     * @Groups({"song"})
     * @ORM\Column(name="length", type="integer")
     */
    private $length;

    /**
     * @var int
     * @Groups({"song"})
     * @ORM\Column(name="type_id", type="integer")
     */
    private $typeId;


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
     * Set title
     *
     * @param string $title
     *
     * @return Song
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Song
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Song
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set artist
     *
     * @param User $artist
     *
     * @return Song
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist
     *
     * @return User
     */
    public function getArtist()
    {
        return $this->artist;
    }
    

    /**
     * Set explicitContent
     *
     * @param boolean $explicitContent
     *
     * @return Song
     */
    public function setExplicitContent($explicitContent)
    {
        $this->explicitContent = $explicitContent;

        return $this;
    }

    /**
     * Get explicitContent
     *
     * @return bool
     */
    public function getExplicitContent()
    {
        return $this->explicitContent;
    }

    /**
     * Set downloadAuthorization
     *
     * @param boolean $downloadAuthorization
     *
     * @return Song
     */
    public function setDownloadAuthorization($downloadAuthorization)
    {
        $this->downloadAuthorization = $downloadAuthorization;

        return $this;
    }

    /**
     * Get downloadAuthorization
     *
     * @return bool
     */
    public function getDownloadAuthorization()
    {
        return $this->downloadAuthorization;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Song
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Song
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set length
     *
     * @param integer $length
     *
     * @return Song
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Get length
     *
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set typeId
     *
     * @param integer $typeId
     *
     * @return Song
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }
}

