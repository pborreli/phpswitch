<?php
namespace tests\units\jubianchi\PhpSwitch\PHP\Option;

use mageekguy\atoum;
use Symfony\Component\Console\Input\InputOption;
use jubianchi\PhpSwitch\PHP\Option\Normalizer as TestedClass;

require_once __DIR__ . '/../../../../bootstrap.php';

class Normalizer extends atoum\test
{
    public function testNormalize()
    {
        $this
            ->if($object = new TestedClass())
            ->then
                ->string($object->normalize(array()))->isEmpty()
            ->if($option = new \mock\jubianchi\PhpSwitch\PHP\Option\Option())
            ->and($this->calling($option)->getAlias = '--option')
            ->and($otherOption = new \mock\jubianchi\PhpSwitch\PHP\Option\Option())
            ->and($this->calling($otherOption)->getAlias = '--otherOption')
            ->then
                ->string($object->normalize(array($option, $otherOption)))->isEqualTo('--option --otherOption')
        ;
    }

    public function testDenormalize()
    {
        $this
            ->if($object = new TestedClass())
            ->and($option = new \mock\jubianchi\PhpSwitch\PHP\Option\Option())
            ->and($this->calling($option)->getAlias = '--option')
            ->and($this->calling($option)->getMode = InputOption::VALUE_OPTIONAL)
            ->and($otherOption = new \mock\jubianchi\PhpSwitch\PHP\Option\Option())
            ->and($this->calling($otherOption)->getAlias = '--otherOption')
            ->then
                ->object($object->denormalize('', array($option, $otherOption)))->isEmpty()
                ->object($object->denormalize('--option', array($option, $otherOption)))->isEqualTo(new \jubianchi\PhpSwitch\PHP\Option\OptionCollection(array($option)))
                ->object($object->denormalize('--option=value', array($option, $otherOption)))->isEqualTo(new \jubianchi\PhpSwitch\PHP\Option\OptionCollection(array($option)))
                ->string($option->getValue())->isEqualTo('value')
        ;
    }
}