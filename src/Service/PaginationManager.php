<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 16/08/18
 * Time: 17:33
 */

namespace App\Service;


class PaginationManager
{
    private $position;
    private $nbreElements;
    private $nbreElementsPerPage;
    private $nbreMaxPageDisplay;

    public function __construct(int $position, int $nbreElement, int $nbreElementPerPage, int $nbreMaxPage){
        $this->position = $position;
        $this->nbreElements = $nbreElement;
        $this->nbreElementsPerPage = $nbreElementPerPage;
        $this->nbreMaxPageDisplay = $nbreMaxPage;
    }

    /**
     * Retourne le nombre de page accésible
     * @return float
     */
    public function getNbrePage(){
        return ceil($this->nbreElements / $this->nbreElementsPerPage);
    }

    /**
     * Retoune le nombre de page à afficher
     * @return float|int
     */
    public function getNbrePageDisplay(){
        if($this->getNbrePage() < $this->nbreMaxPageDisplay){
            return $this->getNbrePage();
        }
        return $this->nbreMaxPageDisplay;
    }

    /**
     *
     * @return bool
     */
    public function isFirst(){
       return ($this->position == 1);
    }

    /**
     * @return bool
     */
    public function isLast(){
        return ($this->position == $this->getNbrePage());
    }

    public function getOffset(){
        $middle = ceil($this->nbreMaxPageDisplay/2);

        if($this->position <= $middle){
            return 1;
        }elseif ($this->position < $this->getNbrePage()-$middle){
            return ($this->position - $this->nbreMaxPageDisplay + $middle);
        }else{
            return ($this->getNbrePage() - $this->nbreMaxPageDisplay + 1);
        }
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getNbreElements()
    {
        return $this->nbreElements;
    }

    /**
     * @param mixed $nbreElements
     */
    public function setNbreElements($nbreElements): void
    {
        $this->nbreElements = $nbreElements;
    }

    /**
     * @return mixed
     */
    public function getNbreElementsPerPage()
    {
        return $this->nbreElementsPerPage;
    }

    /**
     * @param mixed $nbreElementsPerPage
     */
    public function setNbreElementsPerPage($nbreElementsPerPage): void
    {
        $this->nbreElementsPerPage = $nbreElementsPerPage;
    }

    /**
     * @return mixed
     */
    public function getNbreMaxPageDisplay()
    {
        return $this->nbreMaxPageDisplay;
    }

    /**
     * @param mixed $nbreMaxPageDisplay
     */
    public function setNbreMaxPageDisplay($nbreMaxPageDisplay): void
    {
        $this->nbreMaxPageDisplay = $nbreMaxPageDisplay;
    }


}