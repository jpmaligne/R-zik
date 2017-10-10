<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\PlaylistSongType;
use AppBundle\Entity\PlaylistSong;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations


class PlaylistSongController extends Controller
{
    
    // Obtenir TOUTES les chansons dans TOUTES les playlists
    /**
     * @Rest\View()
     * @Rest\Get("/playlistSongs")
     */
    public function getPlaylistsSongsAction(Request $request)
    {
        $playlistsSongs = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:PlaylistSong')
            ->findAll();
        /* @var $playlistsSongs PlaylistSong[] */
        
        return $playlistsSongs;
    }
    
    //Obtenir toutes les chansons d'UNE playlist
    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"playlistsong", "song", "playlist"})
     * @Rest\Get("/playlistSong/{playlist_id}")
     */
    public function getPlaylistSongsAction(Request $request)
    {
        $playlistSongs = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:PlaylistSong')
            ->findBy(['playlist' => $request->get('playlist_id')]);
        /* @var $playlistSongs PlaylistSong */
        
        if (empty($playlistSongs)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('PlaylistSongs not found');
        }
        
        return $playlistSongs;
    }
    
    
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/playlistSong")
     */
    public function postPlaylistSongAction(Request $request)
    {
        $playlistSong= new PlaylistSong();
        $form = $this->createForm(PlaylistSongType::class, $playlistSong, ['csrf_protection' => false, 'validation_groups'=>['Default', 'New']]);
        
        $form->submit($request->request->all());
        
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($playlistSong);
            $em->flush();
            return $playlistSong;
        } else {
            return $form;
        }
    }
    
    /**
     * @Rest\View()
     * @Rest\Put("/playlistSong/{id}")
     */
    public function updatePlaylistSongAction(Request $request)
    {
        return $this->updatePlaylistSong($request, true);
    }
    
    /**
     * @Rest\View()
     * @Rest\Patch("/playlistSong/{id}")
     */
    public function patchPlaylistSongAction(Request $request)
    {
        return $this->updatePlaylistSong($request, false);
    }
    
    private function updatePlaylistSong(Request $request, $clearMissing)
    {
        $playlistSong = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:PlaylistSong')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $playlistSong PlaylistSong */
        
        if (empty($playlistSong)) {
            return $this->playlistSongNotFound();
        }
        
        if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = []; // Le groupe de validation par défaut de Symfony est Default
        }
        
        $form = $this->createForm(PlaylistSongType::class, $playlistSong, $options);
        
        $form->submit($request->request->all(), $clearMissing);
        
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($playlistSong);
            $em->flush();
            return $playlistSong;
        } else {
            return $form;
        }
    }
    
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/playlistSong/{id}")
     */
    public function removePlaylistSongAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $playlistSong = $em->getRepository('AppBundle:PlaylistSong')
            ->find($request->get('id'));
        /* @var $playlistSong PlaylistSong */
        
        if ($playlistSong) {
            $em->remove($playlistSong);
            $em->flush();
        }
    }
    
    private function playlistSongNotFound()
    {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('PlaylistSong not found');
    }
}
