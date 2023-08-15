<?php

namespace Rodrigopedra\TableStream;

use Symfony\Component\Console\Output\OutputInterface as SymfonyOutputInterface;

class SymfonyOutput implements OutputInterface
{
    private SymfonyOutputInterface $output;

    public function __construct(SymfonyOutputInterface $output)
    {
        $this->output = $output;
    }

    public function formatHeader(string $header): string
    {
        return '<fg=green>' . $header . '</>';
    }

    public function writeLine(string $line): void
    {
        $this->output->writeln($line);
    }
}
