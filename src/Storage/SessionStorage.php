<?php

namespace Tito10047\PersistentPreferenceBundle\Storage;

use Symfony\Component\HttpFoundation\RequestStack;

final class SessionStorage implements StorageInterface
{
    private const SESSION_PREFIX = '_persistent_preference_';

	public function __construct(
		private readonly RequestStack $requestStack
	) {}

	public function get(string $context, string $key, mixed $default = null): mixed {
		// TODO: Implement get() method.
	}

	public function set(string $context, string $key, mixed $value): void {
		// TODO: Implement set() method.
	}

	public function setMultiple(string $context, array $values): void {
		// TODO: Implement setMultiple() method.
	}

	public function remove(string $context, string $key): void {
		// TODO: Implement remove() method.
	}

	public function has(string $context, string $key): bool {
		// TODO: Implement has() method.
	}

	public function all(string $context): array {
		// TODO: Implement all() method.
	}
}