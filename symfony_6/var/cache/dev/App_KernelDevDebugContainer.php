<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerQ3EsJxx\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerQ3EsJxx/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerQ3EsJxx.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerQ3EsJxx\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerQ3EsJxx\App_KernelDevDebugContainer([
    'container.build_hash' => 'Q3EsJxx',
    'container.build_id' => '2d6fff41',
    'container.build_time' => 1690918903,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerQ3EsJxx');
