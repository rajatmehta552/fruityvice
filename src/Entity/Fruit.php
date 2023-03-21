<?php

namespace App\Entity;

// src/Entity/Fruit.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FruitRepository")
 */
class Fruit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $family;

    /**
     * @ORM\Column(type="float")
     */
    private $calories;

    /**
     * @ORM\Column(type="float")
     */
    private $fat;

    /**
     * @ORM\Column(type="float")
     */
    private $carbohydrates;

    /**
     * @ORM\Column(type="float")
     */
    private $protein;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $favorite = false;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param mixed $family
     */
    public function setFamily($family): void
    {
        $this->family = $family;
    }

    /**
     * @return mixed
     */
    public function getCalories()
    {
        return $this->calories;
    }

    /**
     * @param mixed $calories
     */
    public function setCalories($calories): void
    {
        $this->calories = $calories;
    }

    /**
     * @return mixed
     */
    public function getFat()
    {
        return $this->fat;
    }

    /**
     * @param mixed $fat
     */
    public function setFat($fat): void
    {
        $this->fat = $fat;
    }

    /**
     * @return mixed
     */
    public function getCarbohydrates()
    {
        return $this->carbohydrates;
    }

    /**
     * @param mixed $carbohydrates
     */
    public function setCarbohydrates($carbohydrates): void
    {
        $this->carbohydrates = $carbohydrates;
    }

    /**
     * @return mixed
     */
    public function getProtein()
    {
        return $this->protein;
    }

    /**
     * @param mixed $protein
     */
    public function setProtein($protein): void
    {
        $this->protein = $protein;
    }

    /**
     * @return bool
     */
    public function isFavorite(): bool
    {
        return $this->favorite;
    }

    /**
     * @param bool $favorite
     */
    public function setFavorite(bool $favorite): void
    {
        $this->favorite = $favorite;
    }



    // getters and setters

}
