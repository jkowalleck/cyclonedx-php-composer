<?php

namespace CycloneDX\Specs;

/**
 * @author jkowalleck
 */
interface SpecInterface
{
    public function getVersion(): string;

    // region Supports

    public function isSupportedComponentType(string $classification): bool;

    /**
     * @return array<string>
     */
    public function getSupportedComponentTypes(): array;

    public function isSupportedHashAlgorithm(string $alg): bool;

    /**
     * @return array<string>
     */
    public function getSupportedHashAlgorithms(): array;

    // endregion Supports
}
