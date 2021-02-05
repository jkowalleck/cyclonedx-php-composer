<?php

use CycloneDX\Spdx\XmlLicensesUpdater;
use PHPUnit\Framework\TestCase;

class XmlSpdxLicensesUpdaterTest extends TestCase
{

    /**
     * @var XmlLicensesUpdater
     */
    private $updater;

    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $schema;

    /**
     * @retrun void
     */
    public function setUp()
    {
        $this->updater = new XmlLicensesUpdater();
        $this->file = __DIR__ . '/../res/licenses.json';
        $this->schema = __DIR__ . '/schema/spdx.xsd';
    }

    /**
     * @return void
     */
    public function tearDown()
    {
        @unlink($this->file);
    }

    /**
     * @return void
     */
    public function testDumpLicenses()
    {
        $this->updater->dumpLicenses($this->file, $this->schema);
        $this->assertFileExists($this->file);

        $json = file_get_contents($this->file);
        $this->assertJson($json);

        $options = 0;

        if (defined('JSON_THROW_ON_ERROR')) {
            $options |= JSON_THROW_ON_ERROR;
        }

        $licenses = json_decode($json, false, 512, $options);
        $this->assertInternalType('array', $licenses);
        $this->assertNotEmpty($licenses);

        foreach ($licenses as &$license) {
            $this->assertInternalType('string', $license);
        }
    }
}
