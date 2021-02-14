<?php

namespace CycloneDX\BomFile;

use CycloneDX\Models\Bom;
use CycloneDX\Specs\SpecInterface;

/**
 * @internal
 *
 * @author jkowalleck
 */
abstract class AbstractFile
{
    // region spec

    /**
     * @var SpecInterface
     */
    protected $spec;

    public function getSpec(): SpecInterface
    {
        return $this->spec;
    }

    public function setSpec(SpecInterface $spec): AbstractFile
    {
        $this->spec = $spec;

        return $this;
    }

    public function __construct(SpecInterface $spec)
    {
        $this->spec = $spec;
    }

    // endregion spec

    // region serialize
    // @TODO move to won structures/interface

    /**
     * Serialize a Bom to a string.
     *
     * May throw {@see \RuntimeException} if spec version is not supported.
     * May throw additional implementation-dependent Exceptions.
     *
     * @param Bom  $bom    The BOM to serialize
     * @param bool $pretty pretty print*
     */
    abstract public function serialize(Bom $bom, bool $pretty = false): string;

    /**
     * Deserialize a Bom to a string.
     *
     * May throw {@see \RuntimeException} if spec version is not supported.
     * May throw additional implementation-dependent Exceptions.
     */
    abstract public function deserialize(string $data): Bom;

    // endregion serialize
}
