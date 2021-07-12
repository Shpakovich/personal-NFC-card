<?php

declare(strict_types=1);

namespace App\Controller\Card;

use App\Model\Entity\User\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/card", name="card")
 */
class CardController extends AbstractController
{
    /**
     * @Route("s", methods={"GET"}, name=".index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        return $this->json(
            [
                ['id' => "00000000-0000-0000-0000-000000000000"],
                ['id' => "11111111-1111-1111-1111-111111111111"],
                ['id' => "22222222-2222-2222-2222-222222222222"],
                ['id' => "33333333-3333-3333-3333-333333333333"],
            ]
        );
    }

    /**
     * @Route("/{id}", methods={"GET"}, name=".show")
     *
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function card(string $id): Response
    {
        if ($id !== '00000000-0000-0000-0000-000000000000') {
            throw new \DomainException('Card not found', 404);
        }

        return $this->json(
            [
                'id' => "00000000-0000-0000-0000-000000000000",
            ]
        );
    }

    /**
     * @Route("/create", methods={"POST"}, name=".create")
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(): JsonResponse
    {
        return $this->json(['id' => Id::next()->getValue()], 201);
    }
}
