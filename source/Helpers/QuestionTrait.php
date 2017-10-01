<?php

namespace Insphptor\Helpers;

use Webmozart\Console\Api\Args\Args;
use Webmozart\Console\Api\IO\IO;
use Webmozart\Console\Adapter\ArgsInput;
use Webmozart\Console\Adapter\IOOutput;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;

trait QuestionTrait
{
    protected function ask(Args $args, IO $io, Question $question)
    {
        $helper = new QuestionHelper();

        return $helper->ask(new ArgsInput($args->getRawArgs(), $args), new IOOutput($io), $question);
    }
}
