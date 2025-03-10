<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePicture = null;

    #[ORM\Column]
    private array $roles = []; 

    private ?string $plainPassword = null;

    /**
     * @var Collection<int, Galeria>
     */
    #[ORM\OneToMany(targetEntity: Galeria::class, mappedBy: 'user')]
    private Collection $galerias;

    /**
     * @var Collection<int, Calificacion>
     */
    #[ORM\OneToMany(targetEntity: Calificacion::class, mappedBy: 'user')]
    private Collection $calificacion;

    /**
     * @var Collection<int, Comentario>
     */
    #[ORM\OneToMany(targetEntity: Comentario::class, mappedBy: 'user')]
    private Collection $comentarios; 

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->galerias = new ArrayCollection();
        $this->calificacion = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture; 
    }

    public function setProfilePicture(?string $profilePicture): static
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }


    /**
     * Obtiene los roles del usuario.
     * Garantiza que siempre haya al menos un rol `ROLE_USER`.
     * 
     * @return array
     */
    public function getRoles(): array
    {
        
        return array_unique($this->roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Borra las credenciales sensibles como la contraseña.
     */
    public function eraseCredentials()
    {
        // Si guardas datos sensibles en el usuario, puedes borrarlos aquí
        // Ejemplo: $this->plainPassword = null;
    }

    /**
     * Devuelve la contraseña en formato adecuado para el PasswordAuthenticatedUserInterface.
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    // Getter y Setter para plainPassword
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return Collection<int, Galeria>
     */
    public function getGalerias(): Collection
    {
        return $this->galerias;
    }

    public function addGaleria(Galeria $galeria): static
    {
        if (!$this->galerias->contains($galeria)) {
            $this->galerias->add($galeria);
            $galeria->setUser($this);
        }

        return $this;
    }

    public function removeGaleria(Galeria $galeria): static
    {
        if ($this->galerias->removeElement($galeria)) {
            // set the owning side to null (unless already changed)
            if ($galeria->getUser() === $this) {
                $galeria->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Calificacion>
     */
    public function getCalificacions(): Collection
    {
        return $this->calificacion;
    }

    public function addCalificacion(Calificacion $calificacion): static
    {
        if (!$this->calificacion->contains($calificacion)) {
            $this->calificacion->add($calificacion);
            $calificacion->setUser($this);
        }

        return $this;
    }

    public function removeCalificacion(Calificacion $calificacion): static
    {
        if ($this->calificacion->removeElement($calificacion)) {
            // set the owning side to null (unless already changed)
            if ($calificacion->getUser() === $this) {
                $calificacion->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comentario>
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentario $comentario): static
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios->add($comentario);
            $comentario->setUser($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): static
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getUser() === $this) {
                $comentario->setUser(null);
            }
        }

        return $this;
    }
}
