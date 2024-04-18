<?php

namespace Src\Entity;

class Contact
{
    private ?int $id;
    private string $name;
    private string $surname;
    private string $telephone;
    private string $email;
    private string $address;

    /**
     * Contact constructor.
     * @param int|null $id
     * @param string $name
     * @param string $surname
     * @param string $telephone
     * @param string $email
     * @param string $address
     */
    public function __construct(
        ?int $id = null,
        string $name = '',
        string $surname = '',
        string $telephone = '',
        string $email = '',
        string $address = ''
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->address = $address;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
}