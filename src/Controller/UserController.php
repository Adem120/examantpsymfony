<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Connection;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/connection', name: 'connection')]
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(Connection::class, $user);
        if ($form->isSubmitted() ) {
            $user=new Utilisateur();
            $user=$doctrine->getRepository(Utilisateur::class)->findOneBy(['email' => $user->getEmail()]);
            if($user){
                localStorage.setItem('user', $user->getEmail());
                return $this->redirectToRoute('app_tache');
            }
        }else{
            return $this->render('tache/connection.html.twig', [
                'form' => $form->createView()
            ]); }
          
    }

}
