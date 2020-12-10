<?php
/**
 * @package     TJCertificate
 * @subpackage  com_tjcertificate
 *
 * @author      Techjoomla <extensions@techjoomla.com>
 * @copyright   Copyright (C) 2009 - 2020 Techjoomla. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Router\Route;

JLoader::import("/techjoomla/media/storage/local", JPATH_LIBRARIES);

/**
 * The Tj Certificate Training Record controller
 *
 * @since  __DEPLOY_VERSION__
 */
class TjCertificateControllerTrainingRecord extends FormController
{
	/**
	 * Method to save a external certficate data.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean|void  Incase of error boolean and in case of success void
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function save($key = 'id', $urlVar = 'id')
	{
		// Check for request forgeries.
		$this->checkToken();
		$app      = Factory::getApplication();
		$user     = Factory::getUser();
		$recordId = $this->input->getInt('id');
		$params = ComponentHelper::getParams('com_tjcertificate');

		if (!$user->id)
		{
			throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'), 403);
		}

		$commonClass = TJCERT::Common();

		// Call common save function
		if ($commonClass->saveTrainingRecord($app->input))
		{
			$this->setRedirect(Route::_('index.php?option=com_tjcertificate&view=certificates&layout=my', false));

			// Flush the data from the session.
			$app->setUserState('com_tjcertificate.edit.trainingrecord.data', null);
		}
	}

	/**
	 * Cancel operation
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function cancel()
	{
		// Check for request forgeries.
		$this->checkToken('request');
		$this->setRedirect(Route::_('index.php?option=com_tjcertificate&view=certificates&layout=my', false));
	}
}
