# Table Stream

Writes continous tabular data to CLI.


## Requirements

- PHP 7.4+
- `mbstring` extension


## Installation

```
composer require rodrigopedra/table-stream
```


## Usage

```php
<?php

require './vendor/autoload.php';

use Rodrigopedra\TableStream\Column;
use Rodrigopedra\TableStream\Table;

$table = new Table([
    // first parameter is the column's header
    // second is your estimated cell width
    // third is the cell alignment
    new Column('#', 8, Column::ALIGN_CENTER),

    // Column::ALIGN_LEFT is the default alignment
    new Column('Date', 19),

    // Fluent "wither" method are also avaialable
    Column::make('Value')->width(13)->alignRight(),
]);

// re-writes header overy 5 rows
$table->offset(5);

foreach (\range(1, 10) as $index) {
    $table->appendRow([
        \number_format($index),
        \date('Y-m-d H:i:s'),
        \uniqid(),
    ]);

    \sleep(1);
}

$table->close();
```

- By the default it uses `echo` to output data
- You can provide a custom `OutputInterface` implementation instead 
- See `./src/SymfonyOutput` for an example using `Symfony\Component\Console\Output\OutputInterface` from `symfony/console` 


### Sample Output

<details>
<summary>Click to expand</summary>

```
+----------+---------------------+---------------+
|    #     |                Date | Value         |
+----------+---------------------+---------------+
|    1     | 2023-08-14 21:48:06 | 64daa11634d36 |
|    2     | 2023-08-14 21:48:07 | 64daa11734dbb |
|    3     | 2023-08-14 21:48:08 | 64daa11834e23 |
|    4     | 2023-08-14 21:48:09 | 64daa11934e76 |
|    5     | 2023-08-14 21:48:10 | 64daa11a34ec7 |
+----------+---------------------+---------------+
|    #     |                Date | Value         |
+----------+---------------------+---------------+
|    6     | 2023-08-14 21:48:11 | 64daa11b34f17 |
|    7     | 2023-08-14 21:48:12 | 64daa11c34f93 |
|    8     | 2023-08-14 21:48:13 | 64daa11d34fe7 |
|    9     | 2023-08-14 21:48:14 | 64daa11e35041 |
|    10    | 2023-08-14 21:48:15 | 64daa11f35093 |
+----------+---------------------+---------------+
```

</details>


### License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
