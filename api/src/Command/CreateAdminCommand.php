<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\Entity\User\Role;
use App\Model\Entity\User\Status;
use App\Model\UseCase\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateAdminCommand extends Command
{
    private const ARG_EMAIL = 'email';
    private const ARG_PASSWORD = 'password';

    protected static $defaultName = 'app:create:admin';
    private User\Create\Handler $handler;
    private ValidatorInterface $validator;

    public function __construct(User\Create\Handler $handler, ValidatorInterface $validator)
    {
        parent::__construct();
        $this->handler = $handler;
        $this->validator = $validator;
    }

    protected function configure(): void
    {
        $this
            ->addArgument(self::ARG_EMAIL, InputArgument::REQUIRED, 'Email')
            ->addArgument(self::ARG_PASSWORD, InputArgument::REQUIRED, 'Пароль')
            ->setDescription('Создать администратора');
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if ($input->getArgument(self::ARG_EMAIL) === null) {
            throw new RuntimeException('Укажите Email администратор');
        }

        /** @var null|string $password */
        $password = $input->getArgument(self::ARG_PASSWORD);
        if ($password === null) {
            throw new RuntimeException('Укажите пароль');
        }

        if (strlen($password) < 5) {
            throw new RuntimeException('Длина пароля должна быть не меньше 5 символов');
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $email */
        $email = $input->getArgument(self::ARG_EMAIL);
        /** @var string $password */
        $password = $input->getArgument(self::ARG_PASSWORD);

        $io = new SymfonyStyle($input, $output instanceof ConsoleOutputInterface ? $output->getErrorOutput() : $output);
        $io->title(sprintf('Создание администратора \'%s\'', $email));

        $command = new User\Create\Command();
        $command->email = $email;
        $command->password = $password;
        $command->role = Role::ADMIN;
        $command->status = Status::ACTIVE;

        /** @var \Symfony\Component\Validator\ConstraintViolationList $errors */
        $errors = $this->validator->validate($command);
        if (\count($errors)) {
            return Command::FAILURE;
        }

        $this->handler->handle($command);

        $io->success('Администратор создан');

        return Command::SUCCESS;
    }
}
