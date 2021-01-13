<?php
require 'console-table/src/LucidFrame/Console/ConsoleTable.php';

$directory = $argv[1];

if(!is_dir($directory)) {
    die('Provided argument is not a directory!');
}

$table = new LucidFrame\Console\ConsoleTable();

$table
    ->addHeader('Permissions')
    ->addHeader('Links')
    ->addHeader('Owner')
    ->addHeader('Group')
    ->addHeader('Size')
    ->addHeader('Month')
    ->addHeader('Day')
    ->addHeader('Time')
    ->addHeader('Filename');

foreach (new DirectoryIterator($directory) as $file) {
    if($file->isDot()) {
        continue;
    }

    $table->addRow()
        ->addColumn($file->getPerms())
        ->addColumn(stat($file->getPathname())['nlink'])
        ->addColumn($file->getOwner())
        ->addColumn($file->getGroup())
        ->addColumn($file->getSize())
        ->addColumn(date("M", $file->getMTime()))
        ->addColumn(date("d", $file->getMTime()))
        ->addColumn(date("H:m", $file->getMTime()))
        ->addColumn($file->getFilename());
}

$table->display();
