<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactsRepository")
 */
class Contacts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z0-9\-]*$/",
     *     message = "Bitte verwenden Sie nur Buchstaben, Zahlen oder - für Ihren Vornamen"
     * )
     * @Assert\Length(
     *     min="2",
     *     max="20",
     *     minMessage = "Der Nachname muss mindestens 2 Zeichen lang sein",
     *     maxMessage = "Der Nachname darf maximal 20 Zeichen lang sein"
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z0-9\-]*$/",
     *     message = "Bitte verwenden Sie nur Buchstaben, Zahlen oder - für Ihren Nachnamen"
     * )
     * @Assert\Length(
     *     min="2",
     *     max="20",
     *     minMessage = "Ihr Nachname muss mindestens 2 Zeichen lang sein",
     *     maxMessage = "Ihr Nachname darf maximal 20 Zeichen lang sein"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "Bitte geben Sie eine korrekte E-Mail Adresse ein. '{{ value }}' ist nicht valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern = "/^[0-9]+/",
     *     message = "Bitte verwenden Sie nur Zahlen für die Telefonnummer"
     * )
     */
    private $telephone;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="0",
     *     max="1000",
     *     minMessage = "Die Nachricht muss mindestens 0 Zeichen haben",
     *     maxMessage = "Die darf nicht länger als 1000 Zeichen lang sein"
     * )
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $street;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Regex(
     *     pattern = "/^[0-9A-Za-z]+/",
     *     message = "Bitte verwenden Sie nur Zahlen oder Buchstaben für die Hausnummer"
     * )
     * @Assert\Length(
     *     min="0",
     *     max="10",
     *     minMessage = "Die Hausnummer muss mindestens 0 Zeichen haben",
     *     maxMessage = "Die Hausnummer darf maximal 10 Zeichen lang sein"
     * )
     */
    private $streetNo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(type="numeric", message="Bitte geben Sie nur Zahlen ein.")
     * @Assert\Regex(
     *     pattern = "/^\d{5}$/",
     *     message = "Bitte geben Sie eine korrekte PLZ ein."
     * )
     * \
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\Length(
     *     min="0",
     *     max="20",
     *     minMessage = "Der Ort muss mindestens 0 Zeichen haben",
     *     maxMessage = "Der Ort darf nicht länger als 20 Zeichen lang sein"
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(
     *     min="0",
     *     max="100",
     *     minMessage = "Der Betreff muss mindestens 0 Zeichen haben",
     *     maxMessage = "Der Betreff darf nicht länger als 1ßß Zeichen lang sein"
     * )
     */
    private $subject;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getStreetNo(): ?string
    {
        return $this->streetNo;
    }

    public function setStreetNo(?string $streetNo): self
    {
        $this->streetNo = $streetNo;

        return $this;
    }

    public function getPostcode(): ?int
    {
        return $this->postcode;
    }

    public function setPostcode(?int $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
