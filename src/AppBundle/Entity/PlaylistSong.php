<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * PlaylistSong
 *
 * @ORM\Table(name="playlist_song")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaylistSongRepository")
 */
class PlaylistSong
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
     * @ORM\ManyToOne(targetEntity="Song")
     * @var Song
     * @Groups({"song", "playlistsong"})
     */
    private $song;
    
    /**
     * @ORM\ManyToOne(targetEntity="Playlist")
     * @var Playlist
     * @Groups({"playlist", "playlistsong"})
     */
    private $playlist;


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
     * Set song
     *
     * @param Song $song
     *
     * @return PlaylistSong
     */
    public function setSong($song)
    {
        $this->song = $song;

        return $this;
    }

    /**
     * Get song
     *
     * @return Song
     */
    public function getSong()
    {
        return $this->song;
    }

    /**
     * Set playlist
     *
     * @param Playlist $playlist
     *
     * @return PlaylistSong
     */
    public function setPlaylist($playlist)
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * Get playlist
     *
     * @return Playlist
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }
}

