<?php
namespace App\Entity;

use App\Repository\UserRepository;
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
    private ?string $profilePicture = null; // Renombrado de 'photo' a 'profilePicture'

    #[ORM\Column]
    private array $roles = []; // Cambiado de 'rol' a 'roles' para más claridad

    // Nuevos campos para latitud y longitud
    #[ORM\Column(type: "float", nullable: true)]
    private ?float $latitud = null;

    #[ORM\Column(type: "float", nullable: true)]
    private ?float $longitud = null;

    private ?string $plainPassword = null; 

    public function __construct()
    {
        // Asignar un rol por defecto
        $this->roles = ['ROLE_USER'];
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
        return $this->profilePicture; // Renombrado a 'getProfilePicture'
    }

    public function setProfilePicture(?string $profilePicture): static
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    // Nuevos métodos para latitud y longitud
    public function getLatitud(): ?float
    {
        return $this->latitud;
    }

    public function setLatitud(?float $latitud): static
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getLongitud(): ?float
    {
        return $this->longitud;
    }

    public function setLongitud(?float $longitud): static
    {
        $this->longitud = $longitud;

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
        // Agrega `ROLE_USER` por defecto si no está asignado
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
}
