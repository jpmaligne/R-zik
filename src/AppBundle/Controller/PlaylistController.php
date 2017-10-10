<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\PlaylistType;
use AppBundle\Entity\Playlist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations


class PlaylistController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/playlists")
     */
    public function getPlaylistsAction(Request $request)
    {
        $playlists = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Playlist')
            ->findAll();
        /* @var $playlists Playlist[] */
        
        return $playlists;
    }
    
    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"playlist", "user"})
     * @Rest\Get("/playlist/{playlist_id}")
     */
    public function getPlaylistAction(Request $request)
    {
        $playlist = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Playlist')
            ->find($request->get('playlist_id'));
        /* @var $playlist Playlist */
        
        if (empty($playlist)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Playlist not found');
        }
        
        return $playlist;
    }
    
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/playlist")
     */
    public function postPlaylistAction(Request $request)
    {
        $playlist = new Playlist();
        $form = $this->createForm(PlaylistType::class, $playlist, ['csrf_protection' => false, 'validation_groups'=>['Default', 'New']]);
        
        $form->submit($request->request->all());
        
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($playlist);
            $em->flush();
            return $playlist;
        } else {
            return $form;
        }
    }
    
    /**
     * @Rest\View()
     * @Rest\Put("/playlist/{id}")
     */
    public function updatePlaylistAction(Request $request)
    {
        return $this->updatePlaylist($request, true);
    }
    
    /**
     * @Rest\View()
     * @Rest\Patch("/playlist/{id}")
     */
    public function patchPlaylistAction(Request $request)
    {
        return $this->updatePlaylist($request, false);
    }
    
    private function updatePlaylist(Request $request, $clearMissing)
    {
        $playlist = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Playlist')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $playlist Playlist */
        
        if (empty($playlist)) {
            return $this->playlistNotFound();
        }
        
        if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = []; // Le groupe de validation par défaut de Symfony est Default
        }
        
        $form = $this->createForm(PlaylistType::class, $playlist, $options);
        
        $form->submit($request->request->all(), $clearMissing);
        
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($playlist);
            $em->flush();
            return $playlist;
        } else {
            return $form;
        }
    }
    
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/playlist/{id}")
     */
    public function removePlaylistAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $playlist = $em->getRepository('AppBundle:Playlist')
            ->find($request->get('id'));
        /* @var $playlist Playlist */
        
        if ($playlist) {
            $em->remove($playlist);
            $em->flush();
        }
    }
    
    private function playlistNotFound()
    {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Playlist not found');
    }
}
