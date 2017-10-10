<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Song;
use AppBundle\Form\Type\SongType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations


class SongController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/songs")
     */
    public function getSongsAction(Request $request)
    {
        $songs = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Song')
            ->findAll();
        /* @var $songs Song[] */
        
        return $songs;
    }
    
    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"song"})
     * @Rest\Get("/song/{song_id}")
     */
    public function getSongAction(Request $request)
    {
        $song = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Song')
            ->find($request->get('song_id'));
        /* @var $song Song */
        
        if (empty($song)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Song not found');
        }
        
        return $song;
    }
    
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/song")
     */
    public function postSongAction(Request $request)
    {
        $song = new Song();
        $form = $this->createForm(SongType::class, $song, ['csrf_protection' => false, 'validation_groups'=>['Default', 'New']]);
        
        $form->submit($request->request->all());
        
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($song);
            $em->flush();
            return $song;
        } else {
            return $form;
        }
    }
    
    /**
     * @Rest\View()
     * @Rest\Put("/song/{id}")
     */
    public function updateSongAction(Request $request)
    {
        return $this->updateSong($request, true);
    }
    
    /**
     * @Rest\View()
     * @Rest\Patch("/song/{id}")
     */
    public function patchSongAction(Request $request)
    {
        return $this->updateSong($request, false);
    }
    
    private function updateSong(Request $request, $clearMissing)
    {
        $song = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Song')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $song Song */
        
        if (empty($song)) {
            return $this->songNotFound();
        }
        
        if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = []; // Le groupe de validation par défaut de Symfony est Default
        }
        
        $form = $this->createForm(SongType::class, $song, $options);
        
        $form->submit($request->request->all(), $clearMissing);
        
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($song);
            $em->flush();
            return $song;
        } else {
            return $form;
        }
    }
    
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/song/{id}")
     */
    public function removeSongAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $song = $em->getRepository('AppBundle:Song')
            ->find($request->get('id'));
        /* @var $song Song */
        
        if ($song) {
            $em->remove($song);
            $em->flush();
        }
    }
    
    private function songNotFound()
    {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Song not found');
    }
}
