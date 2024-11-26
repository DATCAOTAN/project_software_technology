<?php

class DrinkDTO {
    private int $id;
    private string $name;
    private ?string $description;
    private ?string $imageUrl;
    private array $details; // Mảng chứa các chi tiết (size, giá tiền, trạng thái)

    // Constructor
    public function __construct(int $id, string $name, ?string $description = null, ?string $imageUrl = null, array $details = []) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
        $this->details = $details;
    }

    // Getter methods
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function getImageUrl(): ?string {
        return $this->imageUrl;
    }

    public function getDetails(): array {
        return $this->details;
    }

    // Setter methods
    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function setImageUrl(?string $imageUrl): void {
        $this->imageUrl = $imageUrl;
    }

    public function setDetails(array $details): void {
        $this->details = $details;
    }

    // Add detail to the details array
    public function addDetail(string $size, float $price, ?string $status = null): void {
        $this->details[] = [
            'size' => $size,
            'price' => $price,
            'status' => $status,
        ];
    }

    // toArray method for serialization
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'imageUrl' => $this->imageUrl,
            'details' => $this->details,
        ];
    }
}
?>