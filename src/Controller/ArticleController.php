<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticleFormType;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Security\Core\User\UserInterface;
class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    //Affichage des articles
    #[Route('/article/affichage', name: 'app_article_affichage')]
	    public function affichage(ArticleRepository $rep): Response
	    {
	        $articles = $rep->findAll();
	        return $this->render('article/affichage.html.twig', ['articles'=>$articles]);
	    }
    //Creation d'un nouveau article
    #[Route('/article/ajouter', name: 'app_article_ajouter')]
 	   public function ajouter_article(ManagerRegistry $doctrine, Request $request, UserInterface $user): Response
 	   {
 	       $article =new Article();
            $article->setDateDeCreation(new \DateTime()); 
            $article->setAuteur($user);
 	       $form=$this->createForm(ArticleFormType::class,$article);
 	       $form->handleRequest($request);
 	       if($form->isSubmitted() && $form->isValid()){
 	           $em= $doctrine->getManager();
 	           $em->persist($article);
 	           $em->flush();
 	           return $this-> redirectToRoute('app_article_affichage');
 	       }
 	       return $this->render('article/creation.html.twig',[
 	           'form'=>$form->createView(),
 	       ]);
 	   }
    //Mise a jour d'article
    #[Route('/article/modifier/{id}', name: 'app_article_modifier')]
     public function miseajour_article(ManagerRegistry $doctrine, Request $request, ArticleRepository $rep, $id): Response
     {
        $article = $rep->find($id);
        $form=$this->createForm(ArticleFormType::class,$article);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->persist($article);
            $em->flush();
            return $this-> redirectToRoute('app_article_affichage');
        }
        return $this->render('article/creation.html.twig',[
            'form'=>$form->createView(),
        ]);
     }
     //Supprimer un article
     #[Route('/article/supprimer/{id}', name: 'app_article_supprimer')]
     public function supprimer_article($id, ArticleRepository $rep, ManagerRegistry $doctrine): Response
     {
         $em= $doctrine->getManager();
         $article= $rep->find($id);
         $em->remove($article);
         $em->flush();
         return $this-> redirectToRoute('app_article_affichage');
     }

    #[Route('/article/afficher/{id}', name: 'app_article_afficher')]
    public function viewArticle(Article $article): Response
    {
        return $this->render('article/afficher.html.twig', ['article' => $article]);
    }

}
