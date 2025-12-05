<?php

namespace Tito10047\PersistentPreferenceBundle\Service;



use Tito10047\PersistentPreferenceBundle\Preference\Service\PreconfiguredPreferenceInterface;
use Tito10047\PersistentPreferenceBundle\Preference\Service\PreferenceInterface;
use Tito10047\PersistentPreferenceBundle\Selection\Service\PreconfiguredSelectionInterface;
use Tito10047\PersistentPreferenceBundle\Selection\Service\SelectionInterface;

interface PersistentManagerInterface extends PreconfiguredSelectionInterface, PreconfiguredPreferenceInterface{

	public function getPreference(string|object $owner): PreferenceInterface;

	public function getPreferenceStorage(): \Tito10047\PersistentPreferenceBundle\Preference\Storage\PreferenceStorageInterface;
	public function getSelection(string $namespace, mixed $owner = null): SelectionInterface;

}