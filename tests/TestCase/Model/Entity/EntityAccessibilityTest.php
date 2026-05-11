<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use FilesystemIterator;

class EntityAccessibilityTest extends TestCase
{
    public function testIdIsNotMassAssignableAcrossEntities(): void
    {
        $entityDir = ROOT . DS . 'src' . DS . 'Model' . DS . 'Entity';
        $iterator = new FilesystemIterator($entityDir, FilesystemIterator::SKIP_DOTS);

        $checked = 0;

        foreach ($iterator as $fileInfo) {
            if (!$fileInfo->isFile()) {
                continue;
            }

            if ($fileInfo->getExtension() !== 'php') {
                continue;
            }

            $basename = $fileInfo->getBasename('.php');
            $className = 'App\\Model\\Entity\\' . $basename;

            if (!class_exists($className)) {
                continue;
            }

            $entity = new $className();
            $this->assertFalse(
                $entity->isAccessible('id'),
                sprintf('Expected %s::id to not be mass assignable', $className)
            );
            $checked++;
        }

        $this->assertGreaterThan(0, $checked);
    }
}

