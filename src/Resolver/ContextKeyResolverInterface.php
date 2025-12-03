<?php

namespace Tito10047\PersistentPreferenceBundle\Resolver;

/**
 * Strategy interface to resolve a context string from an arbitrary object.
 */
interface ContextKeyResolverInterface
{
	public function supports(object $context): bool;

	public function resolve(object $context): string;
}