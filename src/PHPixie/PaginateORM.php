<?php

namespace PHPixie;

class PaginateORM
{
    protected $paginate;
    protected $builder;
    
    public function __construct($paginate)
    {
        $this->builder = $this->buildBuilder($paginate);
    }
    
    public function queryLoader($query, $preload = array(), $fields = null)
    {
        return $this->builder->queryLoader($query, $preload, $fields);
    }
    
    public function queryPager($query, $pageSize, $preload = array(), $fields = null)
    {
        return $this->builder->queryPager($query, $pageSize, $preload, $fields);
    }
    
    public function builder()
    {
        return $this->builder;
    }
    
    protected function buildBuilder($paginate)
    {
        return new PaginateORM\Builder($paginate);
    }
}
