<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\LivrablesPartiels;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablesPartielsRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ApiResource(
 *     collectionOperations={
 *        "get_CompetencesByReferentielPromo"={
 *              "method"="GET",
 *              "path"="api/formateur/promo/{idPro}/referentiel/{id}/competences" ,
 *              "route_name"="getCompetencesByReferentielPromo",
 *              "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') ",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *         },
 * 
 *        "post_CommentairesLivrablesPartielsFormateur"={
 *              "method"="POST",
 *              "path"="api/formateur/LivrablesPartiels/{idLiv}/commentaire" ,
 *              "route_name"="postCommentairesLivrablesPartielsFormateur",
 *              "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_APPRENANT')",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *         },
 * 
 *        "post_CommentairesLivrablesPartielsApprenant"={
 *              "method"="POST",
 *              "path"="api/apprenant/LivrablesPartiels/{idLiv}/commentaire" ,
 *              "route_name"="postCommentairesLivrablesPartielsApprenant",
 *              "security"="is_granted('ROLE_APPRENANT') or is_granted('ROLE_ADMIN') or is_granted('ROLE_APPRENANT')",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *         },
 * 
 *        "get_CommentairesLivrablesPartiels"={
 *              "method"="GET",
 *              "path"="api/formateur/LivrablesPartiels/{idLiv}/commentaire" ,
 *              "route_name"="getCommentairesLivrablesPartiels",
 *              "security"="is_granted('ROLE_FORMATEUR') or is_granted('ROLE_ADMIN') or is_granted('ROLE_APPRENANT')",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass=LivrablesPartielsRepository::class)
 */

class LivrablesPartiels
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $delai;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, inversedBy="livrablesPartiels")
     */
    private $Niveau;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archivage;

    /**
     * @ORM\ManyToOne(targetEntity=PromoBrief::class, inversedBy="livrablePartiels")
     */
    private $promoBrief;

    /**
     * @ORM\OneToMany(targetEntity=LivrableRendu::class, mappedBy="livrablesPartiels")
     */
    private $livrableRendus;

    public function __construct()
    {
        $this->Niveau = new ArrayCollection();
        $this->livrableRendus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

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

    public function getDelai(): ?\DateTimeInterface
    {
        return $this->delai;
    }

    public function setDelai(?\DateTimeInterface $delai): self
    {
        $this->delai = $delai;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->Niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->Niveau->contains($niveau)) {
            $this->Niveau[] = $niveau;
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->Niveau->contains($niveau)) {
            $this->Niveau->removeElement($niveau);
        }

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(?bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    public function getPromoBrief(): ?PromoBrief
    {
        return $this->promoBrief;
    }

    public function setPromoBrief(?PromoBrief $promoBrief): self
    {
        $this->promoBrief = $promoBrief;

        return $this;
    }

    /**
     * @return Collection|LivrableRendu[]
     */
    public function getLivrableRendus(): Collection
    {
        return $this->livrableRendus;
    }

    public function addLivrableRendu(LivrableRendu $livrableRendu): self
    {
        if (!$this->livrableRendus->contains($livrableRendu)) {
            $this->livrableRendus[] = $livrableRendu;
            $livrableRendu->setLivrablesPartiels($this);
        }

        return $this;
    }

    public function removeLivrableRendu(LivrableRendu $livrableRendu): self
    {
        if ($this->livrableRendus->contains($livrableRendu)) {
            $this->livrableRendus->removeElement($livrableRendu);
            // set the owning side to null (unless already changed)
            if ($livrableRendu->getLivrablesPartiels() === $this) {
                $livrableRendu->setLivrablesPartiels(null);
            }
        }

        return $this;
    }
}
