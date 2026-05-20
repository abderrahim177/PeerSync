<?php

class HelpRequest {

    private int $id;
    private string $title;
    private string $description;
    private string $status;

    public function __construct(
        int $id,
        string $title,
        string $description,
        string $status
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;

        // validation status
        if (!in_array($status, [
            Status::PENDING,
            Status::ASSIGNED,
            Status::RESOLVED
        ])) {
            throw new Exception("Invalid status");
        }

        $this->status = $status;
    }

    // GETTERS

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    // SETTERS

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setStatus(string $status): void
    {
        if (!in_array($status, [
            Status::PENDING,
            Status::ASSIGNED,
            Status::RESOLVED
        ])) {
            throw new Exception("Invalid status");
        }

        $this->status = $status;
    }

    // BUSINESS METHODS

    public function assign(): void
    {
        $this->status = Status::ASSIGNED;
    }

    public function resolve(): void
    {
        $this->status = Status::RESOLVED;
    }
}