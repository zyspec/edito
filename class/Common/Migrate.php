<?php

namespace XoopsModules\Edito\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

use \Xmf\Database\Tables;
use \XoopsModules\Edito\Common;

/**
 * Class Migrate synchronize existing tables with target schema
 *
 * @category  Migrate
 * @author    Richard Griffith <richard@geekwright.com>
 * @copyright 2016 XOOPS Project (https://xoops.org)
 * @license   GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @link      https://xoops.org
 */
class Migrate extends \Xmf\Database\Migrate
{
    private $renameTables;
    private $renameColumns;
    private $moduleDirName;

    /**
     * Migrate constructor
     *
     * @param Common\Configurator $configurator
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __construct(?Common\Configurator $configurator = null)
    {
        $this->moduleDirName = basename(dirname(dirname(__DIR__)));

        if (null !== $configurator) {
            $this->renameTables = $configurator->renameTables;
            $this->renameColumns = $configurator->renameColumns;
            $this->moduleDirName = basename(dirname(__DIR__, 2));
            parent::__construct($this->moduleDirName);
        }
    }

    /**
     * Renames modules dB tables on a module update.
     *
     * The list of dB tables to be renamed are imported
     * using the module {@see Configurator}. This method renames the
     * tables based on the values in the 'renameTables' array.
     *
     * @return  void
     */
    private function renameTable()
    {
        foreach ($this->renameTables as $oldName => $newName) {
            if ($this->tableHandler->useTable($oldName) && !$this->tableHandler->useTable($newName)) {
                $this->tableHandler->renameTable($oldName, $newName);
            }
        }
    }

    /**
     * Rename dB column in table if needed.
     *
     * @return bool success if table column is changed (or did not exist), false if failed to rename
     */
    private function renameColumn(): bool
    {
        $success = true;
        /**
         * @var  string  $table name of the table containing the column to rename
         * @var  string[]  $columns in the form ['from' => 'OldColumnName', 'to' => 'NewColumnName>']
         */
        foreach ($this->renameColumns as $table => $columns) {
            if ($this->tableHandler->useTable($table)) { // table exists, otherwise ignore column rename
                $attributes = $this->tableHandler->getColumnAttributes($table, $columns['from']);
                if (false !== $attributes) { // means column exists, so try and rename it
                    $success = $success && $this->tableHandler->alterColumn($table, $columns['from'], $attributes, $columns['to']);
                }
            }
        }
        return $success;
    }

    /**
     * Change integer IPv4 column to varchar IPv6 capable
     *
     * @param string $tableName  table to convert
     * @param string $columnName column with IP address
     */
    private function convertIPAddresses($tableName, $columnName)
    {
        if ($this->tableHandler->useTable($tableName)) {
            $attributes = $this->tableHandler->getColumnAttributes($tableName, $columnName);
            if (false !== mb_strpos($attributes, ' int(')) {
                if (false === mb_strpos($attributes, 'unsigned')) {
                    $this->tableHandler->alterColumn($tableName, $columnName, " bigint(16) NOT NULL  DEFAULT '0' ");
                    $this->tableHandler->update($tableName, [$columnName => "4294967296 + $columnName"], "WHERE $columnName < 0", false);
                }
                $this->tableHandler->alterColumn($tableName, $columnName, " varchar(45)  NOT NULL  DEFAULT '' ");
                $this->tableHandler->update($tableName, [$columnName => "INET_NTOA($columnName)"], '', false);
            }
        }
    }

    /**
     * Move do* columns from newbb_posts to newbb_posts_text table
     */
    private function moveDoColumns()
    {
        $tableName    = 'newbb_posts_text';
        $srcTableName = 'newbb_posts';
        if ($this->tableHandler->useTable($tableName)
            && $this->tableHandler->useTable($srcTableName)) {
            $attributes = $this->tableHandler->getColumnAttributes($tableName, 'dohtml');
            if (false === $attributes) {
                $this->synchronizeTable($tableName);
                $updateTable = $GLOBALS['xoopsDB']->prefix($tableName);
                $joinTable   = $GLOBALS['xoopsDB']->prefix($srcTableName);
                $sql         = "UPDATE `$updateTable` t1 INNER JOIN `$joinTable` t2 ON t1.post_id = t2.post_id \n" . "SET t1.dohtml = t2.dohtml,  t1.dosmiley = t2.dosmiley, t1.doxcode = t2.doxcode\n" . '  , t1.doimage = t2.doimage, t1.dobr = t2.dobr';
                $this->tableHandler->addToQueue($sql);
            }
        }
    }

    /**
     * Perform any upfront actions before synchronizing the schema
     *
     * __Some typical uses include:__
     *  - table and column renames
     *  - data conversions
     *
     * @return bool
     */
    protected function preSyncActions(): bool
    {
        // change rename any tables necessary
        /**
         * @var string $table
         * @var string[] $columns
         */
        $tblSuccess = $this->renameTable();

        // rename columns AFTER renaming tables
        $colSuccess = $this->renameColumn();

        return $tblSuccess && $colSuccess;
    }
}
