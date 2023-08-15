<?php

namespace Rodrigopedra\TableStream;

class EchoOutput implements OutputInterface
{
    public function formatHeader(string $header): string
    {
        return $header;
    }

    public function writeLine(string $line): void
    {
        echo $line, \PHP_EOL;
    }
}
