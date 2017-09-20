<?php

namespace Insphptor\Storage;

use Insphptor\Patterns\Repository;

class ComponentsRepository extends Repository
{
    public function create()
    {
        $this->items = [
            'namespace' => \Insphptor\Components\NamespaceComponent::class,
            'name' => \Insphptor\Components\NameComponent::class,
            'type' => \Insphptor\Components\TypeComponent::class,
            'attributes' => \Insphptor\Components\AttributesComponent::class,
            'methods' => \Insphptor\Components\MethodsComponent::class,
        ];
    }
}
