<?php
/**
 * @package    Mod_Videoview
 * @author     Dmitry Rekun <d.rekuns@gmail.com>
 * @copyright  Copyright (C) 2020 Dmitry Rekun. All rights reserved.
 * @license    GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

\JLoader::register('ModVideoviewHelper', __DIR__ . '/helper.php');

$data = ModVideoviewHelper::getDisplayData($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require ModuleHelper::getLayoutPath('mod_videoview', $params->get('layout', 'default'));
