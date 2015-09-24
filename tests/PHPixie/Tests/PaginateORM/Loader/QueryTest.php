<?php

namespace PHPixie\Tests\PaginateORM;

/**
 * @coversDefaultClass \PHPixie\PaginateORM\Loader\Query
 */
class QueryTest extends \PHPixie\Test\Testcase
{
    protected $query;
    protected $preload = array('trixie');
    
    protected $repository;
    
    protected $originalLimit  = 5;
    protected $originalOffset = 10;
    
    public function setUp()
    {
        $this->query = $this->query(5, 10);
        $this->repository = $this->repository();
    }
    
    /**
     * @covers ::__construct
     * @covers ::<protected>
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::getCount
     * @covers ::<protected>
     */
    public function testGetCount()
    {
        $this->prepareRestoreLimitAndOffset(
            $this->originalLimit,
            $this->originalOffset
        );
        $this->method($this->query, 'count', 7, array(), 2);
        
        $this->assertSame(7, $this->repository->getCount());
    }
    
    /**
     * @covers ::getItems
     * @covers ::<protected>
     */
    public function testGetItems()
    {
        $this->getItemsTest(false);
        $this->getItemsTest(true);
    }
    
    protected function getItemsTest($withOffset = false)
    {
        $originalOffset = $withOffset ? 3 : null;
        
        $this->query      = $this->query(null, $originalOffset);
        $this->repository = $this->repository();
        $query = $this->query;
        
        $offset = 7;
        
        if($originalOffset === null) {
            $offset+= $originalOffset;
        }
        
        $this->method($query, 'limit', $query, array(5), 0);
        $this->method($query, 'offset', $query, array($offset), 1);
        
        $loader = $this->quickMock('\PHPixie\ORM\Loaders\Loader');
        $this->method($query, 'find', $loader, array(), 2);
        
        $this->prepareRestoreLimitAndOffset(null, $originalOffset, 3);
        
        $this->assertSame($loader, $this->repository->getItems($offset, 5));
    }
    
    protected function prepareRestoreLimitAndOffset($limit, $offset, $at = 0)
    {
        $query = $this->query;
        
        $this->method($query, 'limit', $query, array($limit), $at++);
        $this->method($query, 'offset', $query, array($offset), $at++);
    }
    
    protected function query($limit, $offset)
    {
        $query = $this->quickMock('\PHPixie\ORM\Models\Type\Database\Query');
        
        $this->method($query, 'getLimit', $limit, array(), 0);
        $this->method($query, 'getOffset', $offset, array(), 1);
        
        return $query;
    }
    
    protected function repository()
    {
        return new \PHPixie\PaginateORM\Loader\Query(
            $this->query,
            $this->preload
        );
    }
}