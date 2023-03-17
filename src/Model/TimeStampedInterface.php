<?php 
namespace App\Model;

use DateTimeInterface;

Interface TimeStampedInterface{
    public function getCreatedAt(): ?\DateTimeImmutable;
    public function setCreatedAt(\DateTimeImmutable $createdAt);

    public function getUpdatedAt(): ?\DateTimeImmutable;

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt);
}