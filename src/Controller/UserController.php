<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user', name: 'app_user')]
    public function show(): Response
    {
        $title = "3A19";
        $test = "Hello World!";
        return $this->render('user/index.html.twig', [
            'title' => $title, 
            'test' => $test,
        ]);
    }

        #[Route('/show2', name: 'app_show2')]
    public function show2(): Response
    {
        $user=array(
            array("id"=>1,"name"=>"John","age"=>25,"image"=>"images/img1.jpg"),
            array("id"=>2,"name"=>"Jane","age"=>30, "image"=>"images/img2.jpg"),
            array("id"=>3,"name"=>"Doe","age"=>35, "image"=>"images/img3.jpg"));
        return $this->render('user/list.html.twig', [
            'users' => $user
        ]);
    }

    #[Route('/details/{nom}', name: 'd')]
    public function details(string $nom): Response
    {
        return $this->render('user/show.html.twig', [
            'controller_name' => 'UserController',
            'nom' => $nom
        ]);
    }
    #[Route('/Listuser', name: 'list_user')]
    public function ListUser(UserRepository $r , ManagerRegistry $mr): Response //1- injection de dépendance
    {
        $result = $r->findAll();  // 2- appel de la méthode findAll() recuperation de tous les utilisateurs
         //3- transmission des données à la vue
        return $this->render('user/index.html.twig', [
            'result' => $result,
        ]);
    }

      #[Route('/addUser', name: 'addUser')]
    public function addUser(ManagerRegistry $mr): Response 
     //3- l'injection de dépendance managerRegistry
    {
        //1- creation de l'instance de l'entité User
        $user = new User();
        //2- affectation des valeurs aux attributs de l'entité
        $user->setName("Alice");
        $user->setAge(28);
        $user->setEmail("alice@example.com");
        //4-recuperation de l'entity manager
        $em=$mr->getManager(); 
        //5- persister l'entité
        $em->persist($user);
        //6- flush
        $em->flush();
        //7- redirection vers la liste des utilisateurs
        return $this->redirectToRoute('list_user');
    }
      #[Route('/updateUser/{id}', name: 'updateUser')]
     public function updateUser(ManagerRegistry $mr,$id, UserRepository $repo): Response 
     //3- l'injection de dépendance managerRegistry + repository + id
    {
        //1- recuperation de l'utilisateur à modifier
       $user = $repo->find($id);
        //2- affectation des nouvelles valeurs aux attributs de l'entité
        $user->setName("amir");
        $user->setAge(29);
        $user->setEmail("amir@yazidi.com");
        //4-recuperation de l'entity manager
        $em=$mr->getManager(); 
        //5- persister l'entité
        $em->persist($user);
        //6- flush
        $em->flush();
        //7- redirection vers la liste des utilisateurs
        return $this->redirectToRoute('list_user');
    }

    #[Route('/deleteUser/{id}', name: 'deleteUser')]
    public function deleteUser(ManagerRegistry $mr,$id, UserRepository $repo): Response 
    //3- l'injection de dépendance managerRegistry + repository + id
   {
       //1- recuperation de l'utilisateur à modifier
       $user = $repo->find($id);
       //4-recuperation de l'entity manager
       $em=$mr->getManager(); 
       //5- persister l'entité
       $em->remove($user);
       //6- flush
       $em->flush();
       //7- redirection vers la liste des utilisateurs
       return $this->redirectToRoute('list_user');
   }


    
    
}