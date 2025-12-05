<?php

namespace Tito10047\PersistentPreferenceBundle\Selection\Normalizer;

use RuntimeException;
use Symfony\Component\PropertyAccess\PropertyAccess;

final class ObjectNormalizer implements IdentifierNormalizerInterface
{
	public function supports(mixed $item): bool
	{
		return is_object($item);
	}

	public function normalize(mixed $item, ?string $identifierPath): string|int
	{
		$accessor = PropertyAccess::createPropertyAccessor();

		if (!$accessor->isReadable($item, $identifierPath)) {
			throw new RuntimeException(sprintf(
				'Cannot read identifier "%s" from object of type "%s".',
				$identifierPath, get_debug_type($item)
			));
		}

		$value = $accessor->getValue($item, $identifierPath);

		if (is_object($value) && method_exists($value, '__toString')) {
			return (string) $value;
		}

		if (is_scalar($value)) {
			return $value;
		}

		throw new RuntimeException('Extracted value is not a scalar.');
	}
}