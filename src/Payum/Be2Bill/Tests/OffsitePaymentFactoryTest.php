<?php
namespace Payum\Be2Bill\Tests;

use Payum\Be2Bill\OffsitePaymentFactory;

class OffsitePaymentFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementPaymentFactoryInterface()
    {
        $rc = new \ReflectionClass('Payum\Be2Bill\OffsitePaymentFactory');

        $this->assertTrue($rc->implementsInterface('Payum\Core\PaymentFactoryInterface'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithoutAnyArguments()
    {
        new OffsitePaymentFactory();
    }

    /**
     * @test
     */
    public function shouldAllowCreatePayment()
    {
        $factory = new OffsitePaymentFactory();

        $payment = $factory->create(array('identifier' => 'anId', 'password' => 'aPass'));

        $this->assertInstanceOf('Payum\Core\Payment', $payment);

        $this->assertAttributeNotEmpty('apis', $payment);
        $this->assertAttributeNotEmpty('actions', $payment);

        $extensions = $this->readAttribute($payment, 'extensions');
        $this->assertAttributeNotEmpty('extensions', $extensions);
    }

    /**
     * @test
     */
    public function shouldAllowCreatePaymentWithCustomApi()
    {
        $factory = new OffsitePaymentFactory();

        $payment = $factory->create(array('payum.api' => new \stdClass()));

        $this->assertInstanceOf('Payum\Core\Payment', $payment);

        $this->assertAttributeNotEmpty('apis', $payment);
        $this->assertAttributeNotEmpty('actions', $payment);

        $extensions = $this->readAttribute($payment, 'extensions');
        $this->assertAttributeNotEmpty('extensions', $extensions);
    }

    /**
     * @test
     */
    public function shouldAllowCreatePaymentConfig()
    {
        $factory = new OffsitePaymentFactory();

        $config = $factory->createConfig();

        $this->assertInternalType('array', $config);
        $this->assertNotEmpty($config);
    }

    /**
     * @test
     *
     * @expectedException \Payum\Core\Exception\LogicException
     * @expectedExceptionMessage The identifier, password fields are required.
     */
    public function shouldThrowIfRequiredOptionsNotPassed()
    {
        $factory = new OffsitePaymentFactory();

        $factory->create();
    }
}
