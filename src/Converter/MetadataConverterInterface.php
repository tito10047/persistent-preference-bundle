<?php

namespace Tito10047\PersistentPreferenceBundle\Converter;

/**
 * Definuje kontrakt pre extrahovanie a hydratáciu komplexných metadát (payload)
 * na uložiteľné a čitateľné dáta.
 */
interface MetadataConverterInterface
{
	/**
	 * Konvertuje objekt metadát na bezpečne uložiteľné pole.
	 *
	 * @param object $metadataObject Objekt (napr. DomainConfig).
	 * @return array The resulting serializable array.
	 */
	public function convertToStorable(object $metadataObject): array;

	/**
	 * Konvertuje uložené pole späť na pôvodný objekt metadát.
	 *
	 * @param array $storedData Pole s metadátami.
	 * @param string $targetClass FQCN cieľovej triedy.
	 *
	 * @return object|null
	 */
	public function convertFromStorable(array $storedData, string $targetClass): ?object;
}