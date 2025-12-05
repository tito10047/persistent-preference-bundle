<?php

namespace Tito10047\PersistentPreferenceBundle\Selection\Normalizer;

use RuntimeException;

final class ScalarNormalizer implements IdentifierNormalizerInterface {

	public function supports(mixed $item): bool {
		return is_scalar($item) && !class_exists($item);
	}

	public function normalize(mixed $item, ?string $identifierPath): string|int {
		if (is_int($item) || is_string($item)) {
			return $item;
		}

		throw new RuntimeException('Item is not a valid scalar type after check.');
	}
}