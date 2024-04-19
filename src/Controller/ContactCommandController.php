<?php

namespace Src\Controller;

use Src\Command\AddContactCommand;
use Src\Command\DeleteContactCommand;
use Src\Infrastructure\SQLiteContactRepository;
use Src\Validation\ContactValidator;

class ContactCommandController
{
    /**
     * @var SQLiteContactRepository Database Repository
     */
    private SQLiteContactRepository $repository;

    /**
     * ContactController constructor.
     * @param SQLiteContactRepository $repository
     */
    public function __construct(SQLiteContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handles adding contact to database
     * @param array $data
     */
    public function add(array $data): void
    {
        $validation = ContactValidator::validateContact($data);
        if (!empty($validation['errors'])) {
            header('Location: /add?errors=' . urlencode($validation['errors']));
            exit;
        }

        $command = new AddContactCommand($this->repository);
        $command->execute(
            $validation['data']['name'],
            $validation['data']['surname'],
            $validation['data']['telephone'],
            $validation['data']['email'],
            $validation['data']['address']
        );

        header('Location: /');
    }

    /**
     * Deletes contact from database
     * @param int $id
     */
    public function delete(int $id): void
    {
        if (!ContactValidator::validateInteger($id) || !$this->repository->existsContact($id)) {
            header('Location: /?error=InvalidIntegerID');
            exit;
        }

        $command = new DeleteContactCommand($this->repository);
        $command->execute($id);

        header('Location: /');
    }
}