<?php

namespace App\Domain\Libraries\Books\DTO;

class StoreLibBookDTO
{
    private ?int $humen_id = null;
    private string $name;
    private string $author;
    private int $lib_resource_type_id;
    private int $lib_publishing_id;
    private ?string $release_date = null;
    private int $page;
    private ?float $price = null;
    private int $number;
    private string $annotation;
    private bool $is_active;
    private ?string $image = null;
    private int $lib_bbk_id;

    public static function fromArray(array $data)
    {
        $dto = new self();
        $dto->setName($data['name']);
        $dto->setAuthor($data['author']);
        $dto->setLibResourceTypeId($data['lib_resource_type_id']);
        $dto->setLibPublishingId($data['lib_publishing_id']);
        $dto->setReleaseDate($data['release_date'] ?? null);
        $dto->setPage($data['page']);
        $dto->setPrice($data['price'] ?? null);
        $dto->setNumber($data['number']);
        $dto->setAnnotation($data['annotation']);
        $dto->setIsActive($data['is_active']);
        $dto->setImage($data['image'] ?? null);
        $dto->setLibBbkId($data['lib_bbk_id']);

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getHumenId(): ?int
    {
        return $this->humen_id;
    }

    /**
     * @param int|null $humen_id
     */
    public function setHumenId(?int $humen_id): void
    {
        $this->humen_id = $humen_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return int
     */
    public function getLibResourceTypeId(): int
    {
        return $this->lib_resource_type_id;
    }

    /**
     * @param int $lib_resource_type_id
     */
    public function setLibResourceTypeId(int $lib_resource_type_id): void
    {
        $this->lib_resource_type_id = $lib_resource_type_id;
    }

    /**
     * @return int
     */
    public function getLibPublishingId(): int
    {
        return $this->lib_publishing_id;
    }

    /**
     * @param int $lib_publishing_id
     */
    public function setLibPublishingId(int $lib_publishing_id): void
    {
        $this->lib_publishing_id = $lib_publishing_id;
    }

    /**
     * @return string|null
     */
    public function getReleaseDate(): ?string
    {
        return $this->release_date;
    }

    /**
     * @param string|null $release_date
     */
    public function setReleaseDate(?string $release_date): void
    {
        $this->release_date = $release_date;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getAnnotation(): string
    {
        return $this->annotation;
    }

    /**
     * @param string $annotation
     */
    public function setAnnotation(string $annotation): void
    {
        $this->annotation = $annotation;
    }

    /**
     * @return bool
     */
    public function isIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     */
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getLibBbkId(): int
    {
        return $this->lib_bbk_id;
    }

    /**
     * @param int $lib_bbk_id
     */
    public function setLibBbkId(int $lib_bbk_id): void
    {
        $this->lib_bbk_id = $lib_bbk_id;
    }
}
