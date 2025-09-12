<?php
namespace App\Domain\Libraries\Resources\DTO;

class StoreLibResourceTypeDTO
{
    private string $name;

    public static function fromArray(array $data)
    {
        $dto = new self();
        $dto->setName($data['name']);
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
}
