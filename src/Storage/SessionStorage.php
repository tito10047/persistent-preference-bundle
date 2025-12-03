<?php

namespace Tito10047\PersistentPreferenceBundle\Storage;

use Symfony\Component\HttpFoundation\RequestStack;

final class SessionStorage implements StorageInterface
{
    private const SESSION_PREFIX = '_persistent_preference_';

	public function __construct(
		private readonly RequestStack $requestStack
	) {}

}