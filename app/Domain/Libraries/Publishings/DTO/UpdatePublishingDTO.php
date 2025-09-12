<?php
namespace App\Domain\Libraries\Publishings\DTO;

use App\Domain\Libraries\Publishings\Models\LibPublishing;

class UpdatePublishingDTO
{
    private string $name;
    private LibPublishing $lib_publishing;

    public static function fromArray(array $data)
    {
        $dto = new self();
        $dto->setName($data['name']);
        $dto->setLibPublishing($data['lib_publishing']);
        return $dto;
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
     * @return LibPublishing
     */
    public function getLibPublishing(): LibPublishing
    {
        return $this->lib_publishing;
    }

    /**
     * @param LibPublishing $lib_publishing
     */
    public function setLibPublishing(LibPublishing $lib_publishing): void
    {
        $this->lib_publishing = $lib_publishing;
    }
}
