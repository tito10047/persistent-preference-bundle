<?php

namespace Tito10047\PersistentPreferenceBundle\Tests\App\AssetMapper\Src;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Tito10047\PersistentPreferenceBundle\DependencyInjection\Compiler\AutoTagContextKeyResolverPass;
use Tito10047\PersistentPreferenceBundle\DependencyInjection\Compiler\AutoTagValueTransformerPass;
use Tito10047\PersistentPreferenceBundle\Resolver\ContextKeyResolverInterface;

class ServiceHelper {

	/**
	 * @param ContextKeyResolverInterface[] $resolvers
	 * @param AutoTagValueTransformerPass[] $transformers
	 */
	public function __construct(
		private readonly iterable $resolvers,
		private readonly iterable $transformers,
	) { }
}