<?php

namespace Rodrigopedra\TableStream;

final class Column
{
    public const ALIGN_LEFT = \STR_PAD_RIGHT;
    public const ALIGN_RIGHT = \STR_PAD_LEFT;
    public const ALIGN_CENTER = \STR_PAD_BOTH;

    private string $header;
    private int $width;
    private int $padTo;

    public function __construct(string $header, int $width, int $alignTo = self::ALIGN_LEFT)
    {
        $this->header = $header;
        $this->width($width);
        $this->alignTo($alignTo);
    }

    public function width(int $width): self
    {
        \assert($width > 0, '$width should be greater than zero');

        $this->width = \max(\mb_strlen($this->header), $width);

        return $this;
    }

    public function alignTo(int $alignTo): self
    {
        \assert(\in_array($alignTo, [
            self::ALIGN_LEFT,
            self::ALIGN_RIGHT,
            self::ALIGN_CENTER,
        ], true), '$padTo should be either Column::ALIGN_LEFT, Column::ALIGN_RIGHT, Column::ALIGN_CENTER');

        $this->padTo = $alignTo;

        return $this;
    }

    public function alignLeft(): self
    {
        return $this->alignTo(self::ALIGN_LEFT);
    }

    public function alignRight(): self
    {
        return $this->alignTo(self::ALIGN_RIGHT);
    }

    public function alignCenter(): self
    {
        return $this->alignTo(self::ALIGN_CENTER);
    }

    public function header(OutputInterface $output): string
    {
        $header = $this->formatValue($this->header);

        return $output->formatHeader($header);
    }

    public function divider(): string
    {
        return $this->formatValue(null, '-');
    }

    public function formatValue(?string $value, string $padWith = ' '): string
    {
        $formatted = \str_pad($value ?? '', $this->width, $padWith, $this->padTo);
        $this->width = \max($this->width, \strlen($formatted));

        return $padWith . $formatted . $padWith;
    }

    public static function make(string $header): self
    {
        return new self($header, \mb_strlen($header));
    }
}
