<?php

namespace Tito10047\PersistentPreferenceBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class PreferenceEvent extends Event
{
	public function __construct(
		public readonly string $context,
		public readonly string $key,
		public readonly mixed $value
	) {}

}