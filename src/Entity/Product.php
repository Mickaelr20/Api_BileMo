<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	#[Groups(['read'])]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	#[Groups(['read'])]
	private ?string $reference = null;

	#[ORM\Column(length: 255)]
	#[Groups(['read'])]
	private ?string $name = null;

	#[ORM\ManyToOne]
	#[Groups(['read'])]
	private ?Brand $brand = null;

	#[ORM\Column(length: 255, type: 'text')]
	#[Groups(['read'])]
	private ?string $description = null;

	#[ORM\Column]
	#[Groups(['read'])]
	private ?float $price = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getReference(): ?string
	{
		return $this->reference;
	}

	public function setReference(string $reference): self
	{
		$this->reference = $reference;

		return $this;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getBrand(): ?Brand
	{
		return $this->brand;
	}

	public function setBrand(?Brand $brand): self
	{
		$this->brand = $brand;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;

		return $this;
	}

	public function getPrice(): ?float
	{
		return $this->price;
	}

	public function setPrice(float $price): self
	{
		$this->price = $price;

		return $this;
	}
}
