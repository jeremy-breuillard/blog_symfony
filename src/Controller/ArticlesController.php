<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('articles/index.html.twig', ['articles' => $articles]);
    }
    

    /**
     * @Route("articles/article/{id}", name="show_article")
     */
    public function show(Article $article, Request $request, EntityManagerInterface $em) : Response
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setArticle($article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();
        }

        return $this->render('articles/article.html.twig', ['article' => $article,
                "form" => $form->createView()
            ]);
    }

}
    /**
     * @Route("/articles/create", methods={"GET", "POST")
     */
    // public function create(Request $request)
    // {
        //     if ($request->isMethod('POST')) {
            //         $data = $request->request->all();

        //         $data['title'];
        //     }

        //     return $this->render('articles/create.html.twig');
        // }



