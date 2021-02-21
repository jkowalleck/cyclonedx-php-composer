<?php

declare(strict_types=1);

/*
 * This file is part of the CycloneDX PHP Composer Plugin.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * SPDX-License-Identifier: Apache-2.0
 * Copyright (c) Steve Springett. All Rights Reserved.
 */

namespace CycloneDX\Models;

use DomainException;

/**
 * @author jkowalleck
 */
class PackageUrl
{
    /**
     * @psalm-var non-empty-string
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $type;

    /**
     * @psalm-var non-empty-string|null
     */
    private $namespace;

    /**
     * @psalm-var non-empty-string
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $name;

    /**
     * @psalm-var non-empty-string|null
     */
    private $version;

    /**
     * @psalm-var non-empty-string|null
     */
    private $qualifiers;

    /**
     * @psalm-var non-empty-string|null
     */
    private $subpath;

    /**
     * @psalm-return non-empty-string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @psalm-param string $type
     *
     * @throws DomainException if value is empty
     * @psalm-return  $this
     */
    public function setType(string $type): self
    {
        if ('' === $type) {
            throw new DomainException('Type must not be empty');
        }

        $this->type = strtolower($type);

        return $this;
    }

    /**
     * @psalm-return non-empty-string|null
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * @psalm-param string|null $namespace
     * @psalm-return $this
     */
    public function setNamespace(?string $namespace): self
    {
        $this->namespace = '' === $namespace ? null : $namespace;

        return $this;
    }

    /**
     * @psalm-return non-empty-string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @psalm-param string $name
     *
     * @throws DomainException if value is empty
     * @psalm-return $this
     */
    public function setName(string $name): self
    {
        if ('' === $name) {
            throw new DomainException('Name must not be empty');
        }
        $this->name = $name;

        return $this;
    }

    /**
     * @psalm-return non-empty-string|null
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @psalm-param string|null $version
     * @psalm-return $this
     */
    public function setVersion(?string $version): self
    {
        $this->version = '' === $version ? null : $version;

        return $this;
    }

    /**
     * @psalm-return non-empty-string|null
     */
    public function getQualifiers(): ?string
    {
        return $this->qualifiers;
    }

    /**
     * @psalm-param string|null $qualifiers
     * @psalm-return $this
     */
    public function setQualifiers(?string $qualifiers): self
    {
        $this->qualifiers = '' === $qualifiers ? null : $qualifiers;

        return $this;
    }

    /**
     * @psalm-return non-empty-string|null
     */
    public function getSubpath(): ?string
    {
        return $this->subpath;
    }

    /**
     * @psalm-param string|null $subpath
     * @psalm-return $this
     */
    public function setSubpath(?string $subpath): self
    {
        $this->subpath = '' === $subpath ? null : $subpath;

        return $this;
    }

    /**
     * @throws DomainException if a value was invalid
     *
     * @see settype()
     * @see setName()
     */
    public function __construct(string $type, string $name)
    {
        $this->setType($type);
        $this->setName($name);
    }
}