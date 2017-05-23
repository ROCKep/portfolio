<?php
/**
 * Created by PhpStorm.
 * User: diabl
 * Date: 23.05.2017
 * Time: 9:41
 */

namespace AppBundle\Form\Model;


class Search
{
    private $search;
    private $criteria;


    public function getSearch()
    {
        return $this->search;
    }

    public function setSearch($search)
    {
        $this->search = $search;
    }

    public function getCriteria()
    {
        return $this->criteria;
    }

    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }


}