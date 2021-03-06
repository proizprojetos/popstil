<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_languages
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Multilang status helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_languages
 * @since       1.7.1
 */
abstract class MultilangstatusHelper
{
	public static function getHomes()
	{
		// Check for multiple Home pages
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('COUNT(*)')
			->from($db->quoteName('#__menu'))
			->where('home = 1')
			->where('published = 1')
			->where('client_id = 0');
		$db->setQuery($query);
		return $db->loadResult();
	}

	public static function getLangswitchers()
	{
		// Check if switcher is published
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('COUNT(*)')
			->from($db->quoteName('#__modules'))
			->where('module = ' . $db->quote('mod_languages'))
			->where('published = 1')
			->where('client_id = 0');
		$db->setQuery($query);
		return $db->loadResult();
	}

	public static function getContentlangs()
	{
		// Check for published Content Languages
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('a.lang_code AS lang_code')
			->select('a.published AS published')
			->from('#__languages AS a');
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public static function getSitelangs()
	{
		// check for published Site Languages
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('a.element AS element')
			->from('#__extensions AS a')
			->where('a.type = ' . $db->quote('language'))
			->where('a.client_id = 0')
			->where('a.enabled = 1');
		$db->setQuery($query);
		return $db->loadObjectList('element');
	}

	public static function getHomepages()
	{
		// Check for Home pages languages
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('language')
			->from($db->quoteName('#__menu'))
			->where('home = 1')
			->where('published = 1')
			->where('client_id = 0');
		$db->setQuery($query);
		return $db->loadObjectList('language');
	}

	public static function getStatus()
	{
		//check for combined status
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Select all fields from the languages table.
		$query->select('a.*', 'l.home')
			->select('a.published AS published')
			->select('a.lang_code AS lang_code')
			->from('#__languages AS a');

		// Select the language home pages
		$query->select('l.home AS home')
			->select('l.language AS home_language')
			->join('LEFT', '#__menu  AS l  ON  l.language = a.lang_code AND l.home=1 AND l.published=1 AND l.language <> \'*\'')
			->select('e.enabled AS enabled')
			->select('e.element AS element')
			->join('LEFT', '#__extensions  AS e ON e.element = a.lang_code')
			->where('e.client_id = 0')
			->where('e.enabled = 1')
			->where('e.state = 0');

		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public static function getContacts()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('u.name, count(cd.language) as counted, MAX(cd.language=' . $db->quote('*') . ') as all_languages')
			->from('#__users AS u')
			->join('LEFT', '#__contact_details AS cd ON cd.user_id=u.id')
			->join('LEFT', '#__languages as l on cd.language=l.lang_code')
			->where('EXISTS (SELECT * from #__content as c where  c.created_by=u.id)')
			->where('(l.published=1 or cd.language=' . $db->quote('*') . ')')
			->where('cd.published=1')
			->group('u.id')
			->having('(counted !=' . count(JLanguageHelper::getLanguages()) . ' OR all_languages=1)')
			->having('(counted !=1 OR all_languages=0)');
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}
