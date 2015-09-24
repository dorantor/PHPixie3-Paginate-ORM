<?php

namespace PHPixie\Tests;

/**
 * @coversDefaultClass \PHPixie\PaginateORM
 */
class PaginateORMTest extends \PHPixie\Test\Testcase
{
    protected $paginate;
    
    protected $paginateOrm;
    
    protected $builder;
    
    public function setUp()
    {
        $this->paginate = $this->quickMock('\PHPixie\Paginate');
        
        $this->paginateOrm = $this->getMockBuilder('\PHPixie\PaginateORM')
            ->setMethods(array('buildBuilder'))
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->builder = $this->quickMock('\PHPixie\PaginateORM\Builder');
        $this->method($this->paginateOrm, 'buildBuilder', $this->builder, array(
            $this->paginate
        ), 0);
        
        $this->paginateOrm->__construct(
            $this->paginate
        );
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstructor()
    {
        
    }
    
    /**
     * @covers ::queryLoader
     * @covers ::<protected>
     */
    public function testQueryLoader()
    {
        $query   = $this->getQuery();
        $preload = array('pixie');
        $loader  = $this->quickMock('\PHPixie\PaginateORM\Loader\Query');
        
        $this->method($this->builder, 'queryLoader', $loader, array($query, $preload), 0);
        $this->assertSame($loader, $this->paginateOrm->queryLoader($query, $preload));
        
        $this->method($this->builder, 'queryLoader', $loader, array($query, array()), 0);
        $this->assertSame($loader, $this->paginateOrm->queryLoader($query));
    }
    
    /**
     * @covers ::queryPager
     * @covers ::<protected>
     */
    public function testArrayPager()
    {
        $query   = $this->getQuery();
        $preload = array('pixie');
        $pager  = $this->quickMock('\PHPixie\Paginate\Pager');
        
        $this->method($this->builder, 'queryPager', $pager, array($query, 15, $preload), 0);
        $this->assertSame($pager, $this->paginateOrm->queryPager($query, 15, $preload));
        
        $this->method($this->builder, 'queryPager', $pager, array($query, 15,array()), 0);
        $this->assertSame($pager, $this->paginateOrm->queryPager($query, 15));
    }
    
    /**
     * @covers ::buildBuilder
     * @covers ::<protected>
     */
    public function testBuildBuilder()
    {
        $this->paginateOrm = new \PHPixie\PaginateORM(
            $this->paginate
        );
        
        $builder = $this->paginateOrm->builder();
        $this->assertInstance($builder, '\PHPixie\PaginateORM\Builder', array(
            'paginate' => $this->paginate
        ));
    }
    
    /**
     * @covers ::builder
     * @covers ::<protected>
     */
    public function testBuilder()
    {
        $this->assertSame($this->builder, $this->paginateOrm->builder());
    }
    
    protected function getQuery()
    {
        return $this->quickMock('\PHPixie\ORM\Models\Type\Database\Query');
    }
}