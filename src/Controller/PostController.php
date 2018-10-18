<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/posts")
 * @author Guillermo Quinteros A. <gu.quinteros@gmail.com>
 */
class PostController extends AbstractController
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var array
     */
    protected static $searchFields = ['title', 'body'];

    /**
     * PostController constructor.
     * @param PaginatorInterface $paginator
     * @param PostRepository $postRepository
     */
    public function __construct(PaginatorInterface $paginator, PostRepository $postRepository)
    {
        $this->paginator = $paginator;
        $this->postRepository = $postRepository;
    }

    /**
     * @param Request $request
     * @param PostRepository $postRepository
     * @return Response
     * @Route("", name="posts", methods="GET")
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        $q = $request->query->get('q');
        $query = $postRepository->search($q, self::$searchFields);

        $entities = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('post/index.html.twig', [ 'entities' => $entities]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/new", name="post_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Post $post
     * @return Response
     * @Route("/{id}", name="post_show", methods="GET")
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', ['post' => $post]);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return Response
     * @Route("/{id}/edit", name="post_edit", methods="GET|POST")
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_edit', ['id' => $post->getId()]);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return Response
     * @Route("/{id}", name="post_delete", methods="DELETE")
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
