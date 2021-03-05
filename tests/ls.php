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
        ->addColumn(convertPermissions( fileperms($file->getPathname()) ))
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

function convertPermissions($perms){
    switch ($perms & 0xF000) {
        case 0xC000: // socket
            $info = 's';
            break;
        case 0xA000: // symbolic link
            $info = 'l';
            break;
        case 0x8000: // regular
            $info = 'r';
            break;
        case 0x6000: // block special
            $info = 'b';
            break;
        case 0x4000: // directory
            $info = 'd';
            break;
        case 0x2000: // character special
            $info = 'c';
            break;
        case 0x1000: // FIFO pipe
            $info = 'p';
            break;
        default: // unknown
            $info = 'u';
    }

// Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
        (($perms & 0x0800) ? 's' : 'x' ) :
        (($perms & 0x0800) ? 'S' : '-'));

// Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
        (($perms & 0x0400) ? 's' : 'x' ) :
        (($perms & 0x0400) ? 'S' : '-'));

// World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
        (($perms & 0x0200) ? 't' : 'x' ) :
        (($perms & 0x0200) ? 'T' : '-'));

    return $info;
}
