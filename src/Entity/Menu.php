<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $menuOrder = null;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'submenus')]
    private Collection $submenus;

    #[ORM\Column]
    private ?bool $isVisible = null;

    #[ORM\ManyToOne]
    private ?Article $article = null;

    #[ORM\ManyToOne]
    private ?Category $category = null;

    #[ORM\ManyToOne]
    private ?Page $page = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    public function __construct()
    {
        $this->submenus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMenuOrder(): ?int
    {
        return $this->menuOrder;
    }

    public function setMenuOrder(?int $menuOrder): self
    {
        $this->menuOrder = $menuOrder;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSubmenus(): Collection
    {
        return $this->submenus;
    }

    public function addSubmenu(self $submenu): self
    {
        if (!$this->submenus->contains($submenu)) {
            $this->submenus->add($submenu);
        }

        return $this;
    }

    public function removeSubmenu(self $submenu): self
    {
        $this->submenus->removeElement($submenu);

        return $this;
    }

    public function isIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
