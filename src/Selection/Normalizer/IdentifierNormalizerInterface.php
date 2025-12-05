<?php

namespace Tito10047\PersistentPreferenceBundle\Selection\Normalizer;

/**
 * Defines the contract for converting a complex item (like an entity or UUID object)
 * into a simple scalar (string|int) for storage.
 */
interface IdentifierNormalizerInterface
{
	/**
	 * Checks if this normalizer can handle the given item.
	 *
	 * @param mixed $item The value to check (scalar, object, array).
	 */
	public function supports(mixed $item): bool;

	/**
	 * Converts the item into a scalar identifier.
	 *
	 * @param mixed $item The object or value to convert.
	 * @param string $identifierPath The property path to use if required (e.g., 'uuid' instead of 'id').
	 * @return string|int The scalar identifier.
	 * @throws \RuntimeException If normalization fails.
	 */
	public function normalize(mixed $item, ?string $identifierPath): string|int;
}