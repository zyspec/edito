<?php

declare(strict_types=1);

namespace XoopsModules\Edito;

/*
 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module: Edito
 *
 * @copyright Copyright {@link https://xoops.org XOOPS Project}
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @author    Kazumi Ono (AKA onokazu)
 * @author    XOOPS Module Development Team
 * @see       http://www.myweb.ne.jp/, https://jp.xoops.org/
 * @link      https://github.com/XoopsModules25x/edito
 */
require_once XOOPS_ROOT_PATH . '/class/xoopsform/formelement.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/formhidden.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/formbutton.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/formelementtray.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/form.php';

require_once __DIR__ . '/EditoGroupFormCheckBox.php';

/**
 * Renders a form for setting module specific group permissions
 *
 * @author  Kazumi Ono  <onokazu@myweb.ne.jp>
 * @copyright  &copy; 2000-2021 {@link https://xoops.org XOOPS Project}
 */
class Notorious extends XoopsForm
{
    /**  @var  int  Module ID */
    protected $_modid;

    /**  @var  array  Tree structure of items */
    protected $_itemTree = [];

    /**  @var string  Name of permission */
    protected $_permName;

    /**  @var  string  Description of permission */
    protected $_permDesc;

    /**  @var array  Appendix ('permname'=>, 'itemid'=>, 'itemname'=>, 'selected'=>) */
    protected $_appendix = [];

    /**
     * Constructor
     *
     * @param  string  $title
     * @param  int  $modid
     * @param  string  $permname
     * @param  string  $permdesc
     * @return  void
     */
    public function __construct($title, $modid, $permname, $permdesc)
    {
        //      $this->XoopsForm($title, 'groupperm_form', XOOPS_URL . '/modules/system/admin/groupperm.php', 'post'); GIJ
        //      $this->XoopsForm($title, 'groupperm_form', '', 'post');

        parent::__construct($title, 'groupperm_form', '', 'post');

        $this->_modid    = (int)$modid;
        $this->_permName = $permname;
        $this->_permDesc = $permdesc;
        $this->addElement(new \XoopsFormHidden('modid', $this->_modid));
    }

    /**
     * Adds an item to which permission will be assigned
     *
     * @param  string  $itemName
     * @param  int  $itemId
     * @param  null|int  $itemParent
     * @return  void
     */
    public function addItem($itemId, $itemName, $itemParent = 0)
    {
        $this->_itemTree[$itemParent]['children'][] = $itemId;

        $this->_itemTree[$itemId] = [
            'parent' => $itemParent,
            'name'   => $itemName,
            'id'     => $itemId,
        ];
    }

    /**
     * Add appendix
     *
     * @param  string  $permName
     * @param  int  $itemId
     * @param  string  $itemName
     * @return  void
     */
    public function addAppendix($permName, $itemId, $itemName)
    {
        $this->_appendix[] = [
            'permname' => $permName,
            'itemid'   => $itemId,
            'itemname' => $itemName,
            'selected' => false,
        ];
    }

    /**
     * Loads all child ids for an item to be used in javascript
     *
     * @param  int  $itemId
     * @param  int[]  $childIds  pass-by-reference
     * @return  void
     */
    private function _loadAllChildItemIds($itemId, &$childIds)
    {
        if (!empty($this->_itemTree[$itemId]['children'])) {
            $first_child = $this->_itemTree[$itemId]['children'];

            foreach ($first_child as $fcid) {
                $childIds[] = $fcid;

                if (!empty($this->_itemTree[$fcid]['children'])) {
                    foreach ($this->_itemTree[$fcid]['children'] as $_fcid) {
                        $childIds[] = $_fcid;

                        $this->_loadAllChildItemIds($_fcid, $childIds);
                    }
                }
            }
        }
    }

    /**
     * Renders the form
     *
     * @return string HTML
     */
    public function render()
    {
        // load all child ids for javascript codes

        foreach (array_keys($this->_itemTree) as $item_id) {
            $this->_itemTree[$item_id]['allchild'] = [];
            $this->_loadAllChildItemIds($item_id, $this->_itemTree[$item_id]['allchild']);
        }

        /**
         * @var  \XoopsGroupPermHandler $gpermHandler
         * @var  \XoopsMemberHandler  $memberHandler
         */
        $gpermHandler  = xoops_getHandler('groupperm');
        $memberHandler = xoops_getHandler('member');
        $glist         = $memberHandler->getGroupList();

        foreach (array_keys($glist) as $i) {
            // get selected item id(s) for each group
            $selected = $gpermHandler->getItemIds($this->_permName, $i, $this->_modid);
            $ele      = new EditoGroupFormCheckBox($glist[$i], 'perms[' . $this->_permName . ']', $i, $selected);
            $ele->setOptionTree($this->_itemTree);

            foreach ($this->_appendix as $key => $append) {
                $this->_appendix[$key]['selected'] = $gpermHandler->checkRight($append['permname'], $append['itemid'], $i, $this->_modid);
            }

            $ele->setAppendix($this->_appendix);
            $this->addElement($ele);
            unset($ele);
        }

        // GIJ start

        $jstray          = new \XoopsFormElementTray(' &nbsp; ');

        $jsuncheckbutton = new \XoopsFormButton('', 'none', _NONE, 'button');
        $jsuncheckbutton->setExtra("onclick=\"with(document.groupperm_form){for(i=0;i<length;i++){if(elements[i].type=='checkbox'){elements[i].checked=false;}}}\"");

        $jscheckbutton   = new \XoopsFormButton('', 'all', _ALL, 'button');
        $jscheckbutton->setExtra("onclick=\"with(document.groupperm_form){for(i=0;i<length;i++){if(elements[i].type=='checkbox' && (elements[i].name.indexOf('module_admin')<0 || elements[i].name.indexOf('[groups][1]')>=0)){elements[i].checked=true;}}}\"");

        $jstray->addElement($jsuncheckbutton);
        $jstray->addElement($jscheckbutton);

        $this->addElement($jstray);

        // GIJ end

        $tray = new \XoopsFormElementTray('');

        $tray->addElement(new \XoopsFormButton('', 'reset', _CANCEL, 'reset'));
        $tray->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        $this->addElement($tray);

        // Hack by marcan : we don't need this title here, as it is managed by smartsection_collapsable

        //$ret = '<h4>' . $this->getTitle() . '</h4>' . $this->_permDesc . '<br>';

        $ret = '';

        // End of Hack by marcan : we don't need this title here, as it is managed by smartsection_collapsable

        $ret .= "<form name='" . $this->getName() . "' id='" . $this->getName() . "' action='" . $this->getAction() . "' method='" . $this->getMethod() . "'" . $this->getExtra() . ">\n<table width='100%' class='outer' cellspacing='1'>\n";

        $elements = $this->getElements();

        foreach (array_keys($elements) as $i) {
            if (!is_object($elements[$i])) {
                $ret .= $elements[$i];
            } elseif (!$elements[$i]->isHidden()) {
                $ret .= "<tr class='top left'><td class='head'>" . $elements[$i]->getCaption();

                if ('' != $elements[$i]->getDescription()) {
                    $ret .= '<br><br><span style="font-weight: normal;">' . $elements[$i]->getDescription() . '</span>';
                }

                $ret .= "</td>\n<td class='even'>\n" . $elements[$i]->render() . "\n</td></tr>\n";
            } else {
                $ret .= $elements[$i]->render();
            }
        }

        return $ret . '</table>' . $GLOBALS['xoopsSecurity']->getTokenHTML() . '</form>';
    }
}
