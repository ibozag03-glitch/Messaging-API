<?php

namespace App\Controller;

use App\Repository\DiscussionRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DiscussionController extends AbstractController
{
    #[Route('/discussions', name: 'app_discussion.index')]
    public function index(DiscussionRepository $repository): Response
    {
        $discussions = $repository->findAll();
        return $this->render('discussion/index.html.twig', [
            'controller_name' => 'Discussions',
            'discussions' => $discussions
        ]);
    }

    #[Route('/discussions/{id}/message', name: 'app_discussion.show',  requirements: ['id' => '\d+'])]
    public function show(int $id, DiscussionRepository $discussionRepository, MessageRepository $messageRepository): Response 
    {
        $discussion = $discussionRepository->find($id);

        if ($discussion === null) {
            throw $this->createNotFoundException('Discussion introuvable.');
        }

        $messages = $messageRepository->findByDiscussion($discussion);

        return $this->render('discussion/show.html.twig', [
            'controller_name' => 'Messages ',
            'discussion' => $discussion,
            'messages' => $messages
        ]);
    }
}
