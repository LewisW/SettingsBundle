<?php
namespace Vivait\SettingsBundle\Services;

use Monolog\Logger;
use Symfony\Component\PropertyAccess\Exception\AccessException;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Vivait\SettingsBundle\Driver\ParametersStorageInterface;
use Vivait\SettingsBundle\Exception\DriverNotFoundException;

class DriversChain {
	protected $drivers = array();

	/**
	 * @param $alias
	 * @param ParametersStorageInterface $definition
	 * @return $this
	 */
	public function addDriver($alias, ParametersStorageInterface $definition)
	{
		$this->drivers[$alias] = $definition;

		return $this;
	}

	public function removeDriver($alias)
	{
		unset($this->drivers[$alias]);

		return $this;
	}

    /**
     * Returns a defined driver based on it alias
     * @param $alias
     * @throws DriverNotFoundException
     * @return ParametersStorageInterface|null
     */
	public function getDriver($alias)
	{
		if (isset($this->drivers[$alias])) {
			return $this->drivers[$alias];
		}

		throw new DriverNotFoundException(sprintf('The driver "%s" could not be found', $alias));
	}

	/**
	 * @return ParametersStorageInterface[]
	 */
	public function getDrivers() {
		return $this->drivers;
	}
}