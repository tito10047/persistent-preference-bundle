<?php

namespace Tito10047\PersistentPreferenceBundle\Tests\Integration\Service;

use PHPUnit\Framework\Attributes\TestWith;
use stdClass;
use Tito10047\PersistentPreferenceBundle\Exception\NormalizationFailedException;
use Tito10047\PersistentPreferenceBundle\Service\PreferenceInterface;
use Tito10047\PersistentPreferenceBundle\Service\PreferenceManagerInterface;
use Tito10047\PersistentPreferenceBundle\Tests\App\AssetMapper\Src\ServiceHelper;
use Tito10047\PersistentPreferenceBundle\Tests\Integration\Kernel\AssetMapperKernelTestCase;
use Tito10047\PersistentPreferenceBundle\Tests\App\AssetMapper\Src\Support\TestList;
use Tito10047\PersistentPreferenceBundle\Enum\PreferenceMode;
use function Zenstruck\Foundry\object;

class PreferenceManagerTest extends AssetMapperKernelTestCase
{
    public function testGetPreferenceAndSelectFlow(): void
    {
        $container = self::getContainer();

        /** @var PreferenceManagerInterface $manager */
        $manager = $container->get('persistent_preference.manager.scalar');
        $this->assertInstanceOf(PreferenceManagerInterface::class, $manager);

        // Use the test normalizer that supports type "array" and requires identifierPath
        $preference = $manager->getPreference('test_key');
        $this->assertInstanceOf(PreferenceInterface::class, $preference);

        // Initially nothing selected
        $this->assertFalse($preference->isSelected( 1));

        // Select single item and verify
        $preference->select( 1);
        $this->assertTrue($preference->isSelected(1));

        // Select multiple
        $preference->selectMultiple([
            2,
            3,
        ]);

        $this->assertTrue($preference->isSelected( 2));
        $this->assertTrue($preference->isSelected( 3));

        $ids = $preference->getSelectedIdentifiers();
        sort($ids);
        $this->assertSame([1, 2, 3], $ids);

        // Unselect one and verify
        $preference->unselect(2);
        $this->assertFalse($preference->isSelected( 2));

        $ids = $preference->getSelectedIdentifiers();
        sort($ids);
        $this->assertSame([1, 3], $ids);
    }

    public function testRegisterSourceThrowsWhenNoLoader(): void
    {
        $container = self::getContainer();

        /** @var PreferenceManagerInterface $manager */
        $manager = $container->get('persistent_preference.manager.default');
        $this->assertInstanceOf(PreferenceManagerInterface::class, $manager);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('No suitable loader found');

        // stdClass is not supported by any IdentityLoader in tests/app
        $manager->registerSource('no_loader_key', new \stdClass());
    }

	public function testAutoBindManager():void {

		$container = self::getContainer();

		/** @var ServiceHelper $helper */
		$helper = $container->get(ServiceHelper::class);
		$this->assertInstanceOf(ServiceHelper::class, $helper);

		$manager = $helper->arrayPreferenceManager;
		$this->assertInstanceOf(PreferenceManagerInterface::class, $manager);


		$data = [
			['id' => 1, 'name' => 'A'],
			['id' => 2, 'name' => 'B'],
			['id' => 3, 'name' => 'C'],
		];

		$manager->registerSource("array_key", $data);
	}

	#[TestWith(['default',[['id' => 1, 'name' => 'A']]])]
	#[TestWith(['scalar',[['id' => 1, 'name' => 'A']]])]
	#[TestWith(['array',[new stdClass()]])]
	public function testThrowExceptionOnBadNormalizer($service,$data):void {

		$container = self::getContainer();

		/** @var PreferenceManagerInterface $manager */
		$manager = $container->get('persistent_preference.manager.'.$service);

		$this->expectException(NormalizationFailedException::class);
		$manager->registerSource("array_key_2", $data);
	}

    public function testRegisterSourceLoadsAllInExcludeMode(): void
    {
        $container = self::getContainer();

        /** @var PreferenceManagerInterface $manager */
        $manager = $container->get('persistent_preference.manager.array');
        $this->assertInstanceOf(PreferenceManagerInterface::class, $manager);

        $data = [
            ['id' => 1, 'name' => 'A'],
            ['id' => 2, 'name' => 'B'],
            ['id' => 3, 'name' => 'C'],
        ];
        $list = new TestList($data);

        $preference = $manager->registerSource('reg_key', $list);
        $this->assertInstanceOf(PreferenceInterface::class, $preference);

        // After registerSource -> rememberAll() should store all ids in ALL context.
        // Switching to EXCLUDE mode means: all are selected unless explicitly excluded.
        $preference->setMode(PreferenceMode::EXCLUDE);
        $ids = $preference->getSelectedIdentifiers();
        sort($ids);
        $this->assertSame([1, 2, 3], $ids);
    }
}
