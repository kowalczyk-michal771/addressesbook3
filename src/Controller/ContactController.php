<?php

namespace Src\Controller;

use Src\Command\AddContactCommand;
use Src\Command\DeleteContactCommand;
use Src\Query\ViewContactQuery;
use Src\Infrastructure\SQLiteContactRepository;
use Src\Validation\ContactValidator;

class ContactController
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
     * @param array $filters
     */
    public function index(array $filters = []): void
    {
        $query = new ViewContactQuery($this->repository);
        $contacts = $query->execute($filters);

        require __DIR__ . '/../../views/index.php';
    }

    /**
     * Shows add contact form
     */
    public function showAddForm(): void
    {
        if (isset($_GET['errors'])) {
            $errors = ContactValidator::validateErrors($_GET['errors']);
        }

        require __DIR__ . '/../../views/add.php';
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