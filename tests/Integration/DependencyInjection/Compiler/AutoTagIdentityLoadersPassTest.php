<?php

namespace Tito10047\PersistentPreferenceBundle\Tests\Integration\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ServiceLocator;
use Tito10047\PersistentPreferenceBundle\Tests\App\AssetMapper\Src\Loader\TestListLoader;
use Tito10047\PersistentPreferenceBundle\Tests\App\AssetMapper\Src\Normalizer\TestArrayNormalizer;
use Tito10047\PersistentPreferenceBundle\Tests\App\AssetMapper\Src\ServiceHelper;
use Tito10047\PersistentPreferenceBundle\Tests\App\AssetMapper\Src\Support\TestList;
use Tito10047\PersistentPreferenceBundle\Tests\Integration\Kernel\AssetMapperKernelTestCase;

class AutoTagIdentityLoadersPassTest extends AssetMapperKernelTestCase
{
    public function testTestListLoaderIsRegisteredAndWorks(): void
    {
        $container = self::getContainer();


		/** @var ServiceHelper $locator */
		$locator = $container->get(ServiceHelper::class);
		$this->assertInstanceOf(ServiceHelper::class, $locator);

        $data = [
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
        ];

        $list = new TestList($data);

        // Find matching loader by tag and supports()
        $foundLoader = null;
        foreach ($locator->loaders as $loader) {
            if ($loader instanceof TestListLoader && $loader->supports($list)) {
                $foundLoader = $loader;
                break;
            }
        }
        $this->assertInstanceOf(TestListLoader::class, $foundLoader, 'Tagged loader supporting TestList should be TestListLoader.');
        $this->assertSame(3, $foundLoader->getTotalCount($list));


    }
}
