<?php

namespace Insphptor\Mock;

use Symfony\Component\Console\Output\OutputInterface;

class ProgressBarMock
{

    public function __construct(OutputInterface $output, $max = 0)
    {
    }
    public function setBarCharacter($char)
    {
    }
    public function setProgressCharacter($char)
    {
    }
    public function setFormat($format)
    {
    }
    public function advance($step = 1)
    {
    }
    public function finish()
    {
    }
    public function start($max = null)
    {
    }
}
