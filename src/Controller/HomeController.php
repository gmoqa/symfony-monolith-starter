<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 * @author Guillermo Quinteros A. <gu.quinteros@gmail.com>
 */
class HomeController extends AbstractController
{
    /**
     * @Route("", name="app_homepage")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }
}
