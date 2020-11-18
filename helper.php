<?php
/**
 * @package    Mod_Videoview
 * @author     Dmitry Rekun <d.rekuns@gmail.com>
 * @copyright  Copyright (C) 2020 Dmitry Rekun. All rights reserved.
 * @license    GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

\JLoader::register('ContentHelperRoute', JPATH_SITE . '/components/com_content/helpers/route.php');

/**
 * Module helper
 *
 * @since  1.0
 */
class ModVideoViewHelper
{
	/**
	 * Gets the data to display.
	 *
	 * @param   Joomla\Registry\Registry  $params  Module parameters.
	 *
	 * @return  array
	 *
	 * @since   1.0
	 */
	public static function getDisplayData($params)
	{
		$article = self::getArticleData($params->get('article'));

		return [
			'youtube'   => self::getYoutubeLink($params->get('youtube')),
			'title'     => !empty($article->title) ? $article->title : '',
			'introtext' => !empty($article->introtext) ? $article->introtext : '',
			'link'      => !empty($article->link) ? $article->link : ''
		];
	}

	/**
	 * Gets the article data.
	 *
	 * @param   integer  $articleId  Article ID.
	 *
	 * @return  object|null  Object with an article data or null if article not found.
	 *
	 * @since   1.0
	 * @throws  \RuntimeException
	 */
	private static function getArticleData($articleId)
	{
		$db = Joomla\CMS\Factory::getDbo();

		$item = $db->setQuery(
			$query = $db->getQuery(true)
			->select($db->quoteName(array('id', 'title', 'catid', 'introtext', 'language')))
			->from($db->quoteName('#__content'))
			->where($db->quoteName('id') . ' = ' . (int) $articleId)
		)->loadObject();

		if (!empty($item))
		{
			$item->link = Joomla\CMS\Router\Route::_(ContentHelperRoute::getArticleRoute($item->id, $item->catid, $item->language));
		}

		return $item;
	}

	/**
	 * Gets embed Youtube link from Youtube URL.
	 *
	 * @param  string  $url  The link to Youtube video.
	 *
	 * @return  string  Embed Youtube link.
	 *
	 * @since   1.0
	 */
	private static function getYoutubeLink($url)
	{
		preg_match_all('~
			# Match non-linked youtube URL in the wild. (Rev:20111012)
			https?://         # Required scheme. Either http or https.
			(?:[0-9A-Z-]+\.)? # Optional subdomain.
			(?:               # Group host alternatives.
			  youtu\.be/      # Either youtu.be,
			| youtube\.com    # or youtube.com followed by
			  \S*             # Allow anything up to VIDEO_ID,
			  [^\w\-\s;]       # but char before ID is non-ID char.
			)                 # End host alternatives.
			([\w\-]{11})      # $1: VIDEO_ID is exactly 11 chars.
			(?=[^\w\-]|$)     # Assert next char is non-ID or EOS.
			(?!               # Assert URL is not pre-linked.
			  [?=&+%\w]*      # Allow URL (query) remainder.
			  (?:             # Group pre-linked alternatives.
				[\'"][^<>]*>  # Either inside a start tag,
			  | </a>          # or inside <a> element text contents.
			  )               # End recognized pre-linked alts.
			)                 # End negative lookahead assertion.
			[?=&+%\w]*        # Consume any URL (query) remainder.
			~ix',
			$url, $matches
		);

		return 'https://www.youtube.com/embed/' . $matches[1][0];
	}
}
