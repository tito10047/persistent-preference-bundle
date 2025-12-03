<?php

namespace Tito10047\PersistentPreferenceBundle\Service;

use Tito10047\PersistentPreferenceBundle\Resolver\ContextKeyResolverInterface;
use Tito10047\PersistentPreferenceBundle\Storage\StorageInterface;
use Tito10047\PersistentPreferenceBundle\Transformer\ValueTransformerInterface;

class PreferenceManager implements PreferenceManagerInterface
{
	/**
	 * @param iterable<ContextKeyResolverInterface> $resolvers
	 * @param iterable<ValueTransformerInterface> $transformers
	 */
	public function __construct(
		private readonly iterable $resolvers = [],
		private readonly iterable $transformers = [],
		private readonly StorageInterface $storage,
	) {}

	public function getPreference(object|string $context): PreferenceInterface
	{
		$contextKey = $this->resolveContextKey($context);

		return new Preference($this->transformers, $contextKey, $this->storage);
	}

	private function resolveContextKey(object|string $context): string
	{
		// 1. If it's already a string, just use it
		if (is_string($context)) {
			return $context;
		}

		// 2. If the object implements your interface, use it (Highest Priority)
		if ($context instanceof PersistentContextInterface) {
			return $context->getPersistentContext();
		}

		// 3. Try external resolvers (e.g. for Symfony UserInterface)
		foreach ($this->resolvers as $resolver) {
			if ($resolver->supports($context)) {
				return $resolver->resolve($context);
			}
		}

		throw new \InvalidArgumentException(sprintf(
			'Could not resolve persistent context for object of type "%s". Implement PersistentContextInterface or register a resolver.',
			get_class($context)
		));
	}
}