<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\UseCase\User\Profile\Create;
use DateTimeInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile", name="profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/create", methods={"POST"}, name=".create")
     *
     * @OA\Post(
     *     summary="Создать профиль и привязать его к зарегистрированной карте (если указана)",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="title", type="string", description="Заголовок профиля"),
     *              @OA\Property(property="name", type="string", description="Имя"),
     *              @OA\Property(property="nickname", type="string", description="Никнейм"),
     *              @OA\Property(
     *                  property="default_name",
     *                  type="integer",
     *                  description="Имя по умолчанию: 1 - имя (по умолчанию), 2 - никнейм",
     *                  default=1
     *              ),
     *              @OA\Property(property="post", type="string", description="Должность"),
     *              @OA\Property(property="description", type="string", description="Описание"),
     *              @OA\Property(
     *                  property="card_id", type="string", description="ID зарегистрированной карты пользователя"
     *              ),
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Профиль создан",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="string", description="ID профиля"),
     *         @OA\Property(property="user", type="string", description="ID пользователя"),
     *         @OA\Property(property="card", type="string", nullable=true, description="ID привязанной карты"),
     *         @OA\Property(property="title", type="string", description="Заголовок профиля"),
     *         @OA\Property(property="name", type="string", description="Имя"),
     *         @OA\Property(property="nickname", type="string", description="Никнейм"),
     *         @OA\Property(property="default_name", type="integer", description="Имя по умолчанию"),
     *         @OA\Property(property="post", type="string", description="Должность"),
     *         @OA\Property(property="description", type="string", description="Описание"),
     *         @OA\Property(property="is_published", type="boolean", description="Опубликован или нет"),
     *         @OA\Property(property="created_at", type="string", description="Дата создания")
     *     )
     * )
     *
     * @OA\Response(
     *     response=400,
     *     description="Ошибки бизнес логики, например, пользователь не найден.",
     *     @OA\JsonContent(ref=@Model(type=Error\DomainError::class))
     * )
     *
     * @OA\Response(
     *     response=422,
     *     description="Ошибка валидации входных данных.",
     *     @OA\JsonContent(ref=@Model(type=Error\ValidationError::class))
     * )
     *
     * @OA\Response(response=401, description="Требуется авторизация")
     *
     * @OA\Tag(name="Profile")
     * @Security(name="Bearer")
     *
     * @param \App\Model\UseCase\User\Profile\Create\Command $command
     * @param \App\Model\UseCase\User\Profile\Create\Handler $handler
     * @param \App\Model\Repository\Profile\ProfileRepository $profiles
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Create\Command $command, Create\Handler $handler, ProfileRepository $profiles): JsonResponse
    {
        /** @var \App\Security\UserIdentity $user */
        $user = $this->getUser();

        $command->id = Id::next()->getValue();
        $command->userId = $user->getId();
        $handler->handle($command);

        $profile = $profiles->getById(new Id($command->id));
        $card = $profile->getCard();

        return $this->json(
            [
                'id' => $profile->getId()->getValue(),
                'user' => $profile->getUser()->getId()->getValue(),
                'card' => $card !== null ? $card->getId()->getValue() : null,
                'title' => $profile->getTitle(),
                'name' => $profile->getName(),
                'nickname' => $profile->getNickname(),
                'default_name' => $profile->getDefaultName(),
                'post' => $profile->getPost(),
                'description' => $profile->getDescription(),
                'is_published' => $profile->isPublished(),
                'created_at' => $profile->getCreatedAt()->format(DateTimeInterface::RFC3339),
            ],
            201
        );
    }
}
