<?php

namespace CycloneDX\Specs;

/**
 * @author jkowalleck
 *
 * @internal
 */
trait SupportsTrait
{
    public function isSupportedComponentType(string $classification): bool
    {
        return in_array($classification, self::COMPONENT_TYPES, true);
    }

    public function getSupportedComponentTypes(): array
    {
        return self::COMPONENT_TYPES;
    }

    public function isSupportedHashAlgorithm(string $alg): bool
    {
        return in_array($alg, self::HASH_ALGORITHMS, true);
    }

    public function getSupportedHashAlgorithms(): array
    {
        return self::HASH_ALGORITHMS;
    }
}
