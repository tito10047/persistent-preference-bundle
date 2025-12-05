<?php

namespace Tito10047\PersistentPreferenceBundle\Selection\Loader;



use Tito10047\PersistentPreferenceBundle\Selection\Normalizer\IdentifierNormalizerInterface;

interface IdentityLoaderInterface {

	public function loadAllIdentifiers(?IdentifierNormalizerInterface $resolver, mixed $source, ?string $identifierPath): array;


	public function getTotalCount(mixed $source): int;

	public function supports(mixed $source):bool;

	public function getCacheKey(mixed $source):string;
}