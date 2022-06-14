<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\PinRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
// php 8.0
// #[ORM\Entity(repositoryClass: PinRepository::class)]
// #[ORM\Table(name:"pins")]
// #[ORM\HasLifecycleCallbacks]

//php 7.*



/**
 * @ORM\Entity(repositoryClass=PinRepository::class)
 * @ORM\Table(name="pins")
 * @ORM\HasLifecycleCallbacks 
 */
class Pin
{
    use Timestampable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre champs ne peut pas être vide !")
     * @Assert\Length(min=3, minMessage="Vous devez avoir un titre de minimum {{ limit }} caractères !")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Votre champs ne peut pas être vide")
     * @Assert\Length(min=10, minMessage="Vous devez avoir une description de minimum {{ limit }} caractères !")
     */
    private $description;

    // php8     , options:['default'=>'CURRENT_TIMESTAMP']
    

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $imageName = "https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg";

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pins")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
