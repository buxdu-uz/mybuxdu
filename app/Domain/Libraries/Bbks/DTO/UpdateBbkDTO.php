<?php

namespace App\Domain\Libraries\Bbks\DTO;

use App\Domain\Libraries\Bbks\Models\LibBbk;

class UpdateBbkDTO
{
    private ?int $sub_id;

    private string $code;

    private string $name;

    private string $info;

    private bool $is_active;

    private LibBbk $lib_bbk;

    public static function fromArray(array $data)
    {
        $dto = new self();
        $dto->setSubId($data['sub_id'] ?? null);
        $dto->setCode($data['code']);
        $dto->setName($data['name']);
        $dto->setInfo($data['info']);
        $dto->setIsActive($data['is_active']);
        $dto->setLibBbk($data['lib_bbk']);

        return $dto;
    }

    /**
     * @return int|null
     */
    public function getSubId(): ?int
    {
        return $this->sub_id;
    }

    /**
     * @param int|null $sub_id
     */
    public function setSubId(?int $sub_id): void
    {
        $this->sub_id = $sub_id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
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
    public function getInfo(): string
    {
        return $this->info;
    }

    /**
     * @param string $info
     */
    public function setInfo(string $info): void
    {
        $this->info = $info;
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
     * @return LibBbk
     */
    public function getLibBbk(): LibBbk
    {
        return $this->lib_bbk;
    }

    /**
     * @param LibBbk $lib_bbk
     */
    public function setLibBbk(LibBbk $lib_bbk): void
    {
        $this->lib_bbk = $lib_bbk;
    }
}
