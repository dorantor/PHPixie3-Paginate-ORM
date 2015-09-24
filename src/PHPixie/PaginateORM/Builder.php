<?php

namespace PHPixie\PaginateORM;

class Builder
{
    protected $paginate;
    
    public function __construct($paginate)
    {
        $this->paginate = $paginate;
    }
    
    public function queryLoader($query, $preload = array())
    {
        return new Loader\Query($query, $preload);
    }
    
    public function queryPager($query, $pageSize, $preload = array())
    {
        $loader = $this->queryLoader($query, $preload);
        return $this->paginate->pager($loader, $pageSize);
    }
}