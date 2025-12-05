<?php

namespace Tito10047\PersistentPreferenceBundle\Selection\Service;

interface PreconfiguredSelectionInterface
{
	public function getSelection(string $namespace, mixed $owner = null): SelectionInterface;
}