<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DiscussionController extends AbstractController
{
    #[Route('/discussions', name: 'app_discussion.index')]
    public function index(): Response
    {
        return $this->render('discussion/index.html.twig', [
            'controller_name' => 'Discussions',
        ]);
    }
}
