<?php

namespace CycloneDX\Models;

use CycloneDX\Enums\AbstractHashAlgorithm;
use DomainException;
use InvalidArgumentException;

class Hash
{
    private const CONTENT_REGEX = '/^(?:[a-fA-F0-9]{32}|[a-fA-F0-9]{40}|[a-fA-F0-9]{64}|[a-fA-F0-9]{96}|[a-fA-F0-9]{128})$/';

    /**
     * @var string
     */
    private $algorithm;

    /**
     * @var string
     */
    private $content;

    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    /**
     * @throws DomainException
     *
     * @return $this
     */
    public function setAlgorithm(string $algorithm): self
    {
        $algorithms = (new \ReflectionClass(AbstractHashAlgorithm::class))->getConstants();
        if (false === in_array($algorithm, $algorithms, true)) {
            throw new DomainException('Unknown algorithm.');
        }
        $this->algorithm = $algorithm;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @return Hash
     */
    public function setContent(string $content): self
    {
        if (false === preg_match(self::CONTENT_REGEX, $content)) {
            throw new InvalidArgumentException('Invalid format.');
        }
        $this->content = $content;

        return $this;
    }

    public function __construct(string $algorithm, string $content)
    {
        $this->setAlgorithm($algorithm);
        $this->setContent($content);
    }
}
