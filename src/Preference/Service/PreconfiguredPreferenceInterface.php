<?php

namespace Tito10047\PersistentPreferenceBundle\Preference\Service;

interface PreconfiguredPreferenceInterface {
	public function getPreference(string|object $owner): PreferenceInterface;

}