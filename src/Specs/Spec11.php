<?php

namespace CycloneDX\Specs;

use CycloneDX\Enums\AbstractClassification;
use CycloneDX\Enums\AbstractHashAlgorithm;

/**
 * @author jkowalleck
 */
class Spec11 implements SpecInterface
{
    use SupportsTrait;

    public function getVersion(): string
    {
        return '1.1';
    }

    // region SupportsTrait

    public const COMPONENT_TYPES = [
        AbstractClassification::APPLICATION,
        AbstractClassification::FRAMEWORK,
        AbstractClassification::LIBRARY,
        AbstractClassification::OPERATING_SYSTEMS,
        AbstractClassification::DEVICE,
        AbstractClassification::FILE,
    ];

    public const HASH_ALGORITHMS = [
        AbstractHashAlgorithm::MD5,
        AbstractHashAlgorithm::SHA_1,
        AbstractHashAlgorithm::SHA_256,
        AbstractHashAlgorithm::SHA_384,
        AbstractHashAlgorithm::SHA_512,
        AbstractHashAlgorithm::SHA3_256,
        AbstractHashAlgorithm::SHA3_512,
    ];

    // endregion SupportsTrait
}
