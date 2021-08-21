<?php

declare(strict_types=1);

namespace App\Controller\Metric;

use App\Exception\InvalidRequestData;
use App\Fetcher\Metric\View\Query;
use App\Fetcher\Metric\View\ViewFetcher;
use App\Fetcher\Profile;
use App\Formatter\Error;
use App\Model\Entity\Common\Id;
use App\Model\Repository\Profile\ProfileRepository;
use App\Security\Voter\Profile\ProfileAccess;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/metric", name="metric")
 */
class ViewController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route("/view", methods={"POST"}, name=".view")
     *
     * @OA\Post(
     *     summary="Получить количество просмотров профиля",
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              required={"profile_id"},
     *              @OA\Property(property="profile_id", type="string", description="ID профиля"),
     *              @OA\Property(property="from", type="string", description="С какой даты (2021-08-21 13:13:43)"),
     *              @OA\Property(property="to", type="string", description="До какой даты (2021-08-22 13:13:43)")
     *          )
     *      )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Количество просмотров",
     *     @OA\JsonContent(
     *         @OA\Property(property="value", type="integer"),
     *     )
     * )
     *
     * @OA\Response(
     *     response=400,
     *     description="Ошибки бизнес логики.",
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
     * @OA\Response(response=403, description="Доступ запрещен")
     *
     * @OA\Tag(name="Metric")
     * @Security(name="Bearer")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Fetcher\Metric\View\ViewFetcher $fetcher
     * @param \App\Model\Repository\Profile\ProfileRepository $profiles
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \App\Exception\InvalidRequestData
     */
    public function show(
        Request $request,
        ViewFetcher $fetcher,
        ProfileRepository $profiles
    ): JsonResponse {
        /** @var string $raw */
        $content = $request->getContent();

        /** @var \App\Fetcher\Metric\View\Query $query */
        $query = $this->serializer->deserialize(
            $content,
            Query::class,
            JsonEncoder::FORMAT
        );

        /** @var \Symfony\Component\Validator\ConstraintViolationList $errors */
        $errors = $this->validator->validate($query);
        if (\count($errors)) {
            throw new InvalidRequestData($errors);
        }

        $profile = $profiles->getById(new Id($query->profileId));
        $this->denyAccessUnlessGranted(ProfileAccess::VIEW, $profile);

        $value = $fetcher->forPeriodByProfileId(
            $query->profileId,
            $query->from,
            $query->to,
        );

        return $this->json(['value' => $value]);
    }
}
