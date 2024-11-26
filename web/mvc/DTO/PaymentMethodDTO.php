<?php
    class PaymentMethodDTO {
        private int $id;
        private string $name;
        private array $details; // Mảng chứa chi tiết phương thức thanh toán

        // Constructor
        public function __construct(int $id, string $name, array $details = []) {
            $this->id = $id;
            $this->name = $name;
            $this->details = $details;
        }

        // Getter methods
        public function getId(): int {
            return $this->id;
        }

        public function getName(): string {
            return $this->name;
        }

        public function getDetails(): array {
            return $this->details;
        }

        // Setter methods
        public function setName(string $name): void {
            $this->name = $name;
        }

        public function setDetails(array $details): void {
            $this->details = $details;
        }

        // Add detail to the details array
        public function addDetail(string $name, float $fee): void {
            $this->details[] = [
                'name' => $name,
                'fee' => $fee,
            ];
        }

        // toArray method for serialization
        public function toArray(): array {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'details' => $this->details,
            ];
        }
        public function jsonSerialize() {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'details' => $this->details
            ];
        }
    }
?>
