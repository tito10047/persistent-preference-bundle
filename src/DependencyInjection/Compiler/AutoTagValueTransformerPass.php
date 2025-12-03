<?php

namespace Tito10047\PersistentPreferenceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Tito10047\PersistentPreferenceBundle\Resolver\ContextKeyResolverInterface;
use Tito10047\PersistentPreferenceBundle\Transformer\ValueTransformerInterface;

final class AutoTagValueTransformerPass implements CompilerPassInterface
{
    public const TAG = 'persistent_preference.value_transformer';

    public function process(ContainerBuilder $container): void
    {
        $parameterBag = $container->getParameterBag();

        /** @var array<string, Definition> $definitions */
        $definitions = $container->getDefinitions();

        foreach ($definitions as $id => $definition) {
            // Skip non-instantiable or special definitions
            if ($definition->isAbstract() || $definition->isSynthetic()) {
                continue;
            }

            // If it already has the tag, skip (idempotent)
            if ($definition->hasTag(self::TAG)) {
                continue;
            }

            // Try to resolve the class name
            $class = $definition->getClass() ?: $id; // Fallback: service id can be FQCN
            if (!is_string($class) || $class === '') {
                continue;
            }

            // Resolve parameters like "%foo.class%"
            $class = $parameterBag->resolveValue($class);
            if (!is_string($class)) {
                continue;
            }

            // Use ContainerBuilder's reflection helper to avoid triggering
            // autoload errors for vendor/dev classes that may not be present.
            $reflection = $container->getReflectionClass($class, false);
            if (!$reflection) {
                continue; // cannot reflect, skip silently
            }

            if ($reflection->implementsInterface(ValueTransformerInterface::class)) {
                $definition->addTag(self::TAG)->setPublic(true);
            }
        }
    }
}
