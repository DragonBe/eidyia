<?php
namespace Eidyia\Service;

class TwitterTest extends \PHPUnit_Framework_TestCase
{
    public function testTwitterCall()
    {
        $twitter = new Twitter();
        $data = $twitter->getList('DragonBe');
        $this->assertSame(10, count($data));
    }
}