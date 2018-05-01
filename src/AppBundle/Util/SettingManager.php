<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace AppBundle\Util;


use AppBundle\Entity\Setting;
use Doctrine\ORM\EntityManagerInterface;

class SettingManager
{
	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * @var \AppBundle\Repository\SettingRepository|\Doctrine\Common\Persistence\ObjectRepository
	 */
	private $repo;

	/**
	 * @var array
	 */
	private $settings;

	/**
	 * SettingManager constructor.
	 *
	 * @param EntityManagerInterface $em
	 */
	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
		$this->repo = $em->getRepository('AppBundle:Setting');
	}

	/**
	 * Get array of all settings values
	 *
	 * @return array
	 */
	public function getSettings()
	{
		$this->loadSettings();
		$tmp = [];
		foreach ($this->settings as $name => $setting) {
			$tmp[$name] = $setting->getValue();
		}
		return $tmp;
	}

	/**
	 * Get array of all settings values
	 *
	 * @return array
	 */
	public function getSettingsEntities($test = null)
	{
		$this->loadSettings();
		$tmp = [];
		foreach ($this->settings as $name => $setting) {
			if (!$test || strpos($name, $test) == 0)
				$tmp[] = $setting;
		}
		return $tmp;
	}

	/**
	 * Gets value of specific setting
	 *
	 * @param $name string
	 *
	 * @return string|null
	 */
	public function getSetting($name)
	{
		$this->loadSettings();
		return isset($this->settings[$name]) ? $this->settings[$name]->getValue() : null;
	}

	/**
	 * Sets new value and returns old value;
	 *
	 * @param $name
	 * @param $value
	 *
	 * @return null|string
	 */
	public function setSetting($name, $value)
	{
		$this->loadSettings();
		/** @var Setting|null $setting */
		$setting = isset($this->settings[$name]) ? $this->settings[$name] : null;
		if ($setting) {
			$old = $setting->getValue();
			$setting->setValue($value);
			$this->em->persist($setting);
			$this->em->flush();
		}
		return $setting ? $old : null;
	}

	/**
	 * Gets enty of specific setting
	 *
	 * @param $name string
	 *
	 * @return Setting|null
	 */
	public function getSettingEntity($name)
	{
		$this->loadSettings();
		return isset($this->settings[$name]) ? $this->settings[$name] : null;
	}

	/**
	 * Update Entity
	 *
	 * @param $name  string
	 * @param $value string
	 * @param $label string
	 * @param $note  string
	 */
	public function updateSettingEntity($name, $value, $label = null, $note = null)
	{
		$this->loadSettings();
		/** @var Setting|null $setting */
		$setting = isset($this->settings[$name]) ? $this->settings[$name] : null;
		if ($setting) {
			$setting->setValue($value);
			$setting->setLabel($label);
			$setting->setNote($note);
			$this->em->persist($setting);
			$this->em->flush();
			$this->settings[$name] = $setting;
		}
		return $setting;
	}

	/**
	 * Create Entity
	 *
	 * @param $name  string
	 * @param $value string
	 * @param $label string
	 * @param $note  string
	 */
	public function createSettingEntity($name, $value, $label = null, $note = null)
	{
		$this->loadSettings();
		/** @var Setting|null $setting */
		$setting = isset($this->settings[$name]) ? $this->settings[$name] : null;
		if (!$setting) {
			$setting = new Setting();
			$setting->setName($name);
			$setting->setValue($value);
			$setting->setLabel($label);
			$setting->setNote($note);
			$this->em->persist($setting);
			$this->em->flush();
			$this->settings[$name] = $setting;
		}
		return $setting;
	}

	/**
	 * Loads all settings and stores them for use later.
	 * Does not load again if already stored.
	 */
	private function loadSettings() {
		if (!$this->settings) {
			$settings = $this->repo->findAll();
			/** @var Setting $setting */
			foreach ($settings as $setting) {
				$this->settings[$setting->getName()] = $setting;
			}
		}
	}
}