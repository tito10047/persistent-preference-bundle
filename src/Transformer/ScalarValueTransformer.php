<?php

namespace Tito10047\PersistentPreferenceBundle\Transformer;

/**
 * Support all basic types. Int, String, Bool, Float, Null
 */
class ScalarValueTransformer implements ValueTransformerInterface{

	public function supports(mixed $value): bool {
		// TODO: Implement transform() method.

	}

	public function transform(mixed $value): mixed {
		// TODO: Implement transform() method.
	}

	public function supportsReverse(mixed $value): bool {
		// TODO: Implement supportsReverse() method.
	}

	public function reverseTransform(mixed $value): mixed {
		// TODO: Implement reverseTransform() method.
	}
}