<?php

namespace Rodrigopedra\TableStream;

interface OutputInterface
{
    public function formatHeader(string $header): string;

    public function writeLine(string $line): void;
}
