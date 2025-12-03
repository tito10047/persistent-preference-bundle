<?php

namespace Tito10047\PersistentPreferenceBundle\Tests\Integration\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ServiceLocator;
use Tito10047\PersistentPreferenceBundle\Tests\App\AssetMapper\Src\Normalizer\TestArrayNormalizer;
use Tito10047\PersistentPreferenceBundle\Tests\App\AssetMapper\Src\ServiceHelper;
use Tito10047\PersistentPreferenceBundle\Tests\Integration\Kernel\AssetMapperKernelTestCase;

class AutoTagIdentifierNormalizersPassTest extends AssetMapperKernelTestCase
{
    public function testTestArrayNormalizerIsRegisteredAndWorks(): void
    {
        $container = self::getContainer();

        /** @var ServiceHelper $locator */
        $locator = $container->get(ServiceHelper::class);
        $this->assertInstanceOf(ServiceHelper::class, $locator);

        $found = null;
        foreach ($locator->normalizers as $service) {
            if ($service instanceof TestArrayNormalizer && $service->supports('array')) {
                $found = $service;
                break;
            }
        }

        $this->assertInstanceOf(TestArrayNormalizer::class, $found, 'Tagged normalizer implementing supports("array") should be TestArrayNormalizer.');

        // Validate behavior via normalize
        $this->assertTrue($found->supports(['id' => 123]));
        $this->assertSame(123, $found->normalize(['id' => 123], 'id'));
        $this->assertSame('abc', $found->normalize(['id' => 'abc'], 'id'));
    }
}
