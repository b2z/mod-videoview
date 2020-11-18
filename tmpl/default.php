<?php
/**
 * @package    Mod_Videoview
 * @author     Dmitry Rekun <d.rekuns@gmail.com>
 * @copyright  Copyright (C) 2020 Dmitry Rekun. All rights reserved.
 * @license    GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;
?>
<div class="mod-videoview<?php echo $moduleclass_sfx; ?>">
	<?php if (!empty($data['youtube'])) : ?>
		<div class="mod-videoview-youtube">
			<iframe width="100%" height="170" src="<?php echo $data['youtube']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
			</iframe>
		</div>
	<?php endif; ?>
	<a class="mod-videoview-title" href="<?php echo $data['link']; ?>">
		<?php echo $data['title']; ?>
	</a>
	<?php if (!empty($data['introtext'])) : ?>
		<div class="mod-videoview-introtext"><?php echo $data['introtext']; ?></div>
	<?php endif; ?>
	<a class="mod-videoview-readmore" href="<?php echo $data['link']; ?>">
		<?php echo Joomla\CMS\Language\Text::_('MOD_VIDEOVIEW_READ_MORE');?>
	</a>
</div>
