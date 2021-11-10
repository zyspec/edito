<?php
/**
 * Object with array of HTML image elements
 *
 * @return object
 */

$icon16Path    = \Xmf\Module\Admin::iconUrl('', 16);

return (object)[
    'name'    => mb_strtoupper(basename(dirname(__DIR__))) . ' IconConfigurator',
    'icons'   => [
        '0'       => "<img src='" . $icon16Path . "/0.png' alt='"        . 0        . "' style='vertical-align:middle'>",
        '1'       => "<img src='" . $icon16Path . "/1.png' alt='"        . 1        . "' style='vertical-align:middle'>",
        'add'     => "<img src='" . $icon16Path . "/add.png' alt='"      . _ADD     . "' style='vertical-align:middle'>",
        'clone'   => "<img src='" . $icon16Path . "/editcopy.png' alt='" . _CLONE   . "' style='vertical-align:middle'>",
        'delete'  => "<img src='" . $icon16Path . "/delete.png' alt='"   . _DELETE  . "' style='vertical-align:middle'>",
        'edit'    => "<img src='" . $icon16Path . "/edit.png'  alt="     . _EDIT    . "' style='vertical-align:middle'>",
        'pdf'     => "<img src='" . $icon16Path . "/pdf.png' alt='"      . _CLONE   . "' style='vertical-align:middle'>",
        'preview' => "<img src='" . $icon16Path . "/view.png' alt='"     . _PREVIEW . "' style='vertical-align:middle'>",
        'print'   => "<img src='" . $icon16Path . "/printer.png' alt='"  . _CLONE   . "' style='vertical-align:middle'>",
    ],
];
