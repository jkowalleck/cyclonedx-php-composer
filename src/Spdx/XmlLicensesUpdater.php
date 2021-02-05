<?php

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

namespace CycloneDX\Spdx;

use DOMDocument;
use RuntimeException;

/**
 * Dump SPDX licences.
 *
 * @author jkowalleck
 */
class XmlLicensesUpdater
{

    /**
     * @param string|null $file
     * @param string $url
     * @return void
     */
    public function dumpLicenses($file = null, $url = 'https://cyclonedx.org/schema/spdx')
    {
        if (null === $file) {
            $file = XmlLicenses::getResourcesFile();
        }

        $options = 0;

        if (defined('JSON_PRETTY_PRINT')) {
            $options |= JSON_PRETTY_PRINT;
        }

        if (defined('JSON_UNESCAPED_SLASHES')) {
            $options |= JSON_UNESCAPED_SLASHES;
        }

        $licenses = json_encode($this->getLicenses($url), $options);
        file_put_contents($file, $licenses);
    }

    /**
     * @param string $url
     *
     * @return string[]
     */
    private function getLicenses($url)
    {
        $data = file_get_contents($url);
        if (false === $data) {
            throw new RuntimeException('Could not fetch ' . $url);
        }

        $doc = new DOMDocument();
        $doc->loadXML($data);

        $licenses = array();
        foreach ($doc->documentElement->getElementsByTagName('enumeration') as $licenseEnum ) {
            $licenses[] = $licenseEnum->getAttribute('value');
        }
        sort($licenses, SORT_REGULAR);
        return $licenses;
    }

}
