<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Controller\Guid;
use App\Controller\PaginationSerializer;
use App\Fetcher\User;
use App\Model\Entity\User\Role;
use App\Model\Entity\User\UserCard;
use App\Security\Voter\User\UserCardAccess;
use DateTimeInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/card", name="user.card")
 */
class CardController extends AbstractController
{
    /**
     * @Route("s", methods={"GET"}, name=".index")
     *
     * @OA\Get(
     *     summary="Получить список зарегистрированных карт пользователя"
     * )
     *
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Номер страницы в пагинации.",
     *     @OA\Schema(type="integer")
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *         @OA\Property(property="items", type="array", description="Список профилей",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="string", description="ID"),
     *                 @OA\Property(property="card_id", type="string", description="ID карты"),
     *                 @OA\Property(property="alias", type="string", description="Псевдоним карты"),
     *                 @OA\Property(property="added_at", type="string", description="Дата добавления"),
     *                 @OA\Property(property="user", type="object", description="Пользователь",
     *                     @OA\Property(property="id", type="string", description="ID"),
     *                     @OA\Property(property="email", type="string", description="Email")
     *                 )
     *             )
     *         ),
     *         @OA\Property(property="pagination", ref=@Model(type=\App\Controller\PaginationSerializer::class))
     *     )
     * )
     *
     * @OA\Response(response=401, description="Требуется авторизация")
     *
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Fetcher\User\CardFetcher $fetcher
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, User\CardFetcher $fetcher): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        /** @var int $perPage */
        $perPage = $this->getParameter('app.items_per_page');

        if ($this->isGranted(Role::ADMIN)) {
            $pagination = $fetcher->all($page, $perPage);
        } else {
            /** @var \App\Security\UserIdentity $user */
            $user = $this->getUser();
            $pagination = $fetcher->all($page, $perPage, $user->getId());
        }

        return $this->json(
            [
                'items' => array_map(
                    static function (array $item) {
                        return [
                            'id' => $item['id'],
                            'card_id' => $item['card_id'],
                            'alias' => $item['alias'],
                            'added_at' => $item['added_at'],
                            'user' => [
                                'id' => $item['user_id'],
                                'email' => $item['user_email'],
                            ]
                        ];
                    },
                    (array)$pagination->getItems()
                ),
                'pagination' => PaginationSerializer::serialize($pagination)
            ]
        );
    }

    /**
     * @Route("/{card_id}", methods={"GET"}, name=".show", requirements={
     *     "id"=Guid::PATTERN
     * })
     * @ParamConverter("card", options={"mapping": {"card_id": "card"}})
     *
     * @OA\Get(
     *     summary="Получить зарегистрированную карту пользователя по ее ID"
     * )
     *
     * @OA\Parameter(
     *     name="card_id",
     *     in="path",
     *     description="ID карты",
     *     required=true,
     *     @OA\Schema(type="string")
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="ID"),
     *         @OA\Property(property="card_id", type="string", description="ID карты"),
     *         @OA\Property(property="alias", type="string", description="Псевдоним карты"),
     *         @OA\Property(property="added_at", type="string", description="Дата добавления"),
     *         @OA\Property(property="user", type="object", description="Пользователь",
     *             @OA\Property(property="id", type="string", description="ID"),
     *             @OA\Property(property="email", type="string", description="Email")
     *         )
     *     )
     * )
     *
     * @OA\Response(response=404, description="Не найдена")
     * @OA\Response(response=401, description="Требуется авторизация")
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     *
     * @param \App\Model\Entity\User\UserCard $card
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(UserCard $card): JsonResponse
    {
        $this->denyAccessUnlessGranted(UserCardAccess::VIEW, $card);

        return $this->json(
            [
                'id' => $card->getId()->getValue(),
                'card_id' => $card->getCard()->getId()->getValue(),
                'alias' => $card->getAlias(),
                'added_at' => $card->getAddedAt()->format(DateTimeInterface::RFC3339),
                'user' => [
                    'id' => $card->getUser()->getId()->getValue(),
                    'email' => $card->getUser()->getEmail()->getValue(),
                ]
            ]
        );
    }
}
