<?php
namespace App\Domain\Libraries\Resources\DTO;

use App\Domain\Libraries\Resources\Models\LibResourceType;

class UpdateLibResourceTypeDTO
{
    private string $name;
    private LibResourceType $lib_resource_type;

    public static function fromArray(array $data)
    {
        $dto = new self();
        $dto->setName($data['name']);
        $dto->setLibResourceType($data['lib_resource_type']);
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
     * @return LibResourceType
     */
    public function getLibResourceType(): LibResourceType
    {
        return $this->lib_resource_type;
    }

    /**
     * @param LibResourceType $lib_resource_type
     */
    public function setLibResourceType(LibResourceType $lib_resource_type): void
    {
        $this->lib_resource_type = $lib_resource_type;
    }
}
