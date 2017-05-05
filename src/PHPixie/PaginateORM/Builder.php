<?php

namespace PHPixie\PaginateORM;

class Builder
{
    protected $paginate;
    
    public function __construct($paginate)
    {
        $this->paginate = $paginate;
    }
    
    public function queryLoader($query, $preload = array(), $fields = null)
    {
        return new Loader\Query($query, $preload, $fields);
    }
    
    public function queryPager($query, $pageSize, $preload = array(), $fields = null)
    {
        $loader = $this->queryLoader($query, $preload, $fields);
        return $this->paginate->pager($loader, $pageSize);
    }
}
