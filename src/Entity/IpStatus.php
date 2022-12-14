<?php

namespace App\Entity;

use App\Repository\IpStatusRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IpStatusRepository::class)]
class IpStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Url(
        protocols: ['http', 'https', 'ftp'],
    )]
    private ?string $ip = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $last_ping = null;

    #[ORM\Column(nullable: true)]
    private ?int $http_response = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLastPing(): ?\DateTimeInterface
    {
        return $this->last_ping;
    }

    public function setLastPing(?\DateTimeInterface $last_ping): self
    {
        $this->last_ping = $last_ping;

        return $this;
    }

    public function getHttpResponse(): ?int
    {
        return $this->http_response;
    }

    public function setHttpResponse(?int $http_response): self
    {
        $this->http_response = $http_response;

        return $this;
    }
}
