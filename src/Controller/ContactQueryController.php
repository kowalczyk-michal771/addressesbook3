<?php

namespace Src\Controller;

use Src\Query\ViewContactQuery;
use Src\Infrastructure\SQLiteContactRepository;
use Src\Validation\ContactValidator;

class ContactQueryController
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
     * Shows list of the contacts
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
    public function showAddForm(string $errors = ''): void
    {
        $validationErrors = [];
        if ($errors) {
            $validationErrors = ContactValidator::validateErrors($errors);
        }

        require __DIR__ . '/../../views/add.php';
    }
}