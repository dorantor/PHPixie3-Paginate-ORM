<?php

namespace PHPixie\Tests\PaginateORM;

class BuilderTest
{
    protected $paginate;
    protected $builder;
    
    public function setUp()
    {
        $this->paginate = $this->quickMock('\PHPixie\Paginate');
        $this->builder  = new \PHPixie\Builder($this->paginate);
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::queryLoader
     * @covers ::<protected>
     */
    public function testQueryLoader()
    {
        $query = $this->getQuery();
        $preload = array('test');
        
        $loader = $this->builder->queryLoader($query, $preload);
        $this->assertInstance($loader, '\PHPixie\PaginateORM\Loader\Query', array(
            'query'   => $query,
            'preload' => $preload
        ));
        
        $loader = $this->builder->queryLoader($query);
        $this->assertInstance($loader, '\PHPixie\PaginateORM\Loader\Query', array(
            'query'   => $query,
            'preload' => array()
        ));

    }
    
    /**
     * @covers ::queryPager
     * @covers ::<protected>
     */
    public function testQueryPager()
    {
        $this->builder = $this->quickMock(
            '\PHPixie\PaginateORM\Builder',
            array($this->paginate),
            array('queryLoader')
        );
        
        $query   = $this->getQuery();
        $preload = $withPreload ? array('trixie') : array();
        $loader = $this->quicMock('\PHPixie\PaginateORM\Loader\Query');
        
        $this->method($this->builder, 'queryLoader', $loader, array($query, $preload), 0);
        
        $pager = $this->quickMock('\PHPixie\Paginate\Pager');
        $this->method($this->paginate, 'pager', $pager, array($loader, 10), 0);
        
        if($withPreload) {
            $result = $this->builder->queryPager($query, 10, $preload);
        }else{
            $result = $this->builder->queryPager($query, 10);
        }
        $this->assertSame($pager, $result);
    }
    
    protected function getQuery()
    {
        return $this->quickMock('\PHPixie\ORM\Models\Type\Database\Query');
    }

}