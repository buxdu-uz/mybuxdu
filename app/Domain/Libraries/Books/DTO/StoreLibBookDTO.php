<?php

namespace App\Domain\Libraries\Books\DTO;

class StoreLibBookDTO
{
    private ?int $humen_id = null;
    private string $name;
    private string $author;
    private int $lib_resource_type_id = null;
    private int $lib_publishing_id = null;
    private ?string $release_date = null;
    private int $page;
    private ?float $price = null;
    private int $number;
    private string $annotation;
    private bool $is_active;
    private ?string $image = null;
    private int $bbk_id;

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
        $dto->setBbkId($data['bbk_id']);

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getHumenId()
    {
        return $this->humen_id;
    }

    /**
     * @param int|null $humen_id
     */
    public function setHumenId($humen_id)
    {
        $this->humen_id = $humen_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return int|null
     */
    public function getLibResourceTypeId()
    {
        return $this->lib_resource_type_id;
    }

    /**
     * @param int|null $lib_resource_type_id
     */
    public function setLibResourceTypeId($lib_resource_type_id)
    {
        $this->lib_resource_type_id = $lib_resource_type_id;
    }

    /**
     * @return int|null
     */
    public function getLibPublishingId()
    {
        return $this->lib_publishing_id;
    }

    /**
     * @param int|null $lib_publishing_id
     */
    public function setLibPublishingId($lib_publishing_id)
    {
        $this->lib_publishing_id = $lib_publishing_id;
    }

    /**
     * @return string|null
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }

    /**
     * @param string|null $release_date
     */
    public function setReleaseDate($release_date)
    {
        $this->release_date = $release_date;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * @param string $annotation
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;
    }

    /**
     * @return bool
     */
    public function isIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
    }

    /**
     * @return string|null
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getBbkId()
    {
        return $this->bbk_id;
    }

    /**
     * @param int $bbk_id
     */
    public function setBbkId($bbk_id)
    {
        $this->bbk_id = $bbk_id;
    }
}
