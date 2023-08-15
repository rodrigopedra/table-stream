<?php

namespace Rodrigopedra\TableStream;

final class Table
{
    private OutputInterface $output;
    private array $columns;
    private int $headerOffset;
    private int $sentinel = 0;

    public function __construct(array $columns, ?OutputInterface $output = null)
    {
        $this->offset(25);

        $this->output = $output ?? new EchoOutput();
        $this->columns = $columns;
    }

    public function offset(int $headerOffset): self
    {
        \assert($headerOffset > -1, '$headerOffset should be a non-negative integer');

        $this->headerOffset = $headerOffset;
        $this->sentinel = $headerOffset;

        return $this;
    }

    public function appendRow(array $row): void
    {
        if ($this->sentinel === $this->headerOffset) {
            $this->writeHeaders();
        }

        $row = \array_values($row);
        $row = \array_map(
            static fn (Column $column, int $index) => $column->formatValue($row[$index]),
            $this->columns,
            \array_keys($this->columns),
        );

        $this->writeRow($row, '|');
        $this->sentinel++;
    }

    public function close(): void
    {
        $this->writeDivider();

        $this->sentinel = 0;
    }

    private function writeDivider(): void
    {
        $divider = \array_map(static fn (Column $column) => $column->divider(), $this->columns);

        $this->writeRow($divider, '+');
    }

    private function writeHeaders(): void
    {
        $fields = \array_map(fn (Column $column) => $column->header($this->output), $this->columns);

        $this->writeDivider();
        $this->writeRow($fields, '|');
        $this->writeDivider();

        $this->sentinel = 0;
    }

    private function writeRow(array $row, string $separator): void
    {
        $this->output->writeLine($separator . \implode($separator, $row) . $separator);
    }
}
