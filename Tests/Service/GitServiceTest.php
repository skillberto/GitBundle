<?php
/**
 * Created by PhpStorm.
 * User: heiszler_n
 * Date: 1/6/2015
 * Time: 3:58 PM
 */

namespace Skillberto\GitBundle\Tests\Service;

use Skillberto\GitBundle\Service\GitService;
use Symfony\Component\Process\Process;

class GitServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTag()
    {
        $this->assertNull($this->invokeStripTag(""));
        $this->assertNull($this->invokeStripTag("1"));
        $this->assertNull($this->invokeStripTag("1."));
        $this->assertEquals("1.2", $this->invokeStripTag("1.2..2"));
        $this->assertEquals("1.2", $this->invokeStripTag("1.2."));
        $this->assertEquals("1.0", $this->invokeStripTag("1.0"));
        $this->assertEquals("1.0.2", $this->invokeStripTag("1.0.2"));
        $this->assertEquals("1.0.2.2", $this->invokeStripTag("1.0.2.2"));
        $this->assertEquals("1.0.2.2", $this->invokeStripTag("1.0.2.2"));
        $this->assertEquals("1.0.2.2", $this->invokeStripTag("1.0.2.2.5"));
    }

    public function testValidate()
    {
        $this->assertTrue($this->invokeValidate("1.0"));
        $this->assertTrue($this->invokeValidate("v1.0"));
        $this->assertTrue($this->invokeValidate("1.2.0.0"));
        $this->assertTrue($this->invokeValidate("v1.2.2"));
        $this->assertTrue($this->invokeValidate("1.2.3.4"));
        $this->assertTrue($this->invokeValidate("v12.5.6.18"));
        $this->assertTrue($this->invokeValidate("v1.2.3"));
        $this->assertTrue($this->invokeValidate("v1.2.4.5"));
        $this->assertFalse($this->invokeValidate(""));
        $this->assertFalse($this->invokeValidate("v1"));
        $this->assertFalse($this->invokeValidate("v1."));
        $this->assertFalse($this->invokeValidate("a1"));
        $this->assertFalse($this->invokeValidate("a1.0"));
        $this->assertFalse($this->invokeValidate("1."));
        $this->assertFalse($this->invokeValidate("1.0.2.4.5"));
        $this->assertFalse($this->invokeValidate("1.2..5"));
    }

    public function testCorrectVersion()
    {
        $map = array(
            "1.0",
            "v1.0",
            "1.2.0.0",
            "1.2.2",
            "v1.2.2",
            "1.2.3.4",
            "v12.5.6.18"
        );

        $gitStub = $this->stubExecuteMethod($map);

        $this->assertEquals("1.0", $gitStub->getVersion());
        $this->assertEquals("1.0", $gitStub->getVersion());
        $this->assertEquals("1.2.0.0", $gitStub->getVersion());
        $this->assertEquals("1.2.2", $gitStub->getVersion());
        $this->assertEquals("1.2.2", $gitStub->getVersion());
        $this->assertEquals("1.2.3.4", $gitStub->getVersion());
        $this->assertEquals("12.5.6.18", $gitStub->getVersion());
    }

    public function testWrongVersion()
    {
        $map = array(
            "",
            "1",
            "v1",
            "v1.",
            "a1",
            "a1.0",
            "1.",
            "1.0.2.4.5",
            "1.2..5"
        );

        $gitStub = $this->stubExecuteMethod($map);

        $this->assertInstanceOf("Skillberto\\GitBundle\\Exception\\InvalidTagException", $gitStub->getVersion());
        $this->assertInstanceOf("Skillberto\\GitBundle\\Exception\\InvalidTagException", $gitStub->getVersion());
        $this->assertInstanceOf("Skillberto\\GitBundle\\Exception\\InvalidTagException", $gitStub->getVersion());
        $this->assertInstanceOf("Skillberto\\GitBundle\\Exception\\InvalidTagException", $gitStub->getVersion());
        $this->assertInstanceOf("Skillberto\\GitBundle\\Exception\\InvalidTagException", $gitStub->getVersion());
        $this->assertInstanceOf("Skillberto\\GitBundle\\Exception\\InvalidTagException", $gitStub->getVersion());
        $this->assertInstanceOf("Skillberto\\GitBundle\\Exception\\InvalidTagException", $gitStub->getVersion());
        $this->assertInstanceOf("Skillberto\\GitBundle\\Exception\\InvalidTagException", $gitStub->getVersion());
        $this->assertInstanceOf("Skillberto\\GitBundle\\Exception\\InvalidTagException", $gitStub->getVersion());
    }

    protected function invokeValidate($data)
    {
        $gitMock = $this->getGitServiceMock();

        return $this->invokeMethod($gitMock, "validate", array($data));
    }

    protected function invokeStripTag($data)
    {
        $gitMock = $this->getGitServiceMock();

        return $this->invokeMethod($gitMock, "stripTag", array($data));
    }

    protected function stubExecuteMethod(array $map)
    {
        $gitStub = $this->getGitServiceMock();

        $gitStub->method('execute')->will($this->returnValueMap($map));

        return $gitStub;
    }

    protected function getGitServiceMock()
    {
        return $this->getMockBuilder('Skillberto\GitBundle\Service\GitService')->getMock();
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
} 