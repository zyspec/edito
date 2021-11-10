<?php

namespace XoopsModules\Edito;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @package  \XoopsModules\Edito
 * @copyright  &copy; 2000-2021 {@link https://xoops.org XOOPS Project}
 * @license  GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author  XOOPS Development Team
 */
//defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Helper
 */
class Helper extends \Xmf\Module\Helper
{
    /** @var  bool */
    public $debug;

    /**
     * @param  null|bool  $debug
     */
    public function __construct($debug = false)
    {
        $this->debug   = $debug;
        $moduleDirName = basename(dirname(__DIR__));
        parent::__construct($moduleDirName);
    }

    /**
     * Instantiate the class
     *
     * @param  bool  $debug
     * @return  \XoopsModules\Edito\Helper
     */
    public static function getInstance($debug = false)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($debug);
        }

        return $instance;
    }

    /**
     * Get the module's directory name
     *
     * @return string
     */
    public function getDirname()
    {
        return $this->dirname;
    }

    /**
     * Get an Object Handler
     *
     * @param  string  $name  name of handler to load
     * @return  bool|\XoopsObjectHandler|\XoopsPersistableObjectHandler
     */
    public function getHandler($name)
    {
        $ret   = false;
        $class =  __NAMESPACE__ . '\\' . ucfirst($name) . 'Handler';
        if (!class_exists($class)) {
            throw new \RuntimeException("Class '$class' not found");
        }
        /** @var  \XoopsMySQLDatabase  $db */
        $db     = \XoopsDatabaseFactory::getDatabaseConnection();
        $helper = self::getInstance();
        $ret    = new $class($db, $helper);
        $this->addLog("Getting handler '{$name}'");
        return $ret;
    }
}

