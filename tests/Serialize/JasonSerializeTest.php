<?php

namespace CycloneDX\Tests\Serialize;

use CycloneDX\Models\Hash;
use CycloneDX\Models\License;
use CycloneDX\Serialize\JsonSerializer;
use CycloneDX\Specs\SpecInterface;
use DomainException;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \CycloneDX\Serialize\JsonSerializer
 *
 * @uses \CycloneDX\Serialize\AbstractSerialize
 */
class JasonSerializeTest extends TestCase
{
    // region hashToJson

    public function testHashToJson(): void
    {
        $algorithm = $this->getRandomString();
        $content = $this->getRandomString();
        $hash = $this->createStub(Hash::class);
        $hash->method('getAlgorithm')->willReturn($algorithm);
        $hash->method('getContent')->willReturn($content);

        $spec = $this->createMock(SpecInterface::class);
        $spec->method('isSupportedHashAlgorithm')->with($algorithm)->willReturn(true);
        $serializer = new JsonSerializer($spec);

        $data = $serializer->hashToJson($hash);

        self::assertIsArray($data);
        self::assertEquals(['alg' => $algorithm, 'content' => $content], $data);
    }

    public function testHashToJsonInvalidAlgorithm(): void
    {
        $algorithm = $this->getRandomString();
        $hash = $this->createStub(Hash::class);
        $hash->method('getAlgorithm')->willReturn($algorithm);

        $spec = $this->createMock(SpecInterface::class);
        $spec->method('isSupportedHashAlgorithm')->with($algorithm)->willReturn(false);
        $serializer = new JsonSerializer($spec);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessageMatches('/invalid algorithm/i');
        $serializer->hashToJson($hash);
    }

    // endregion hashToJson

    // region licenseToJson

    /**
     * @dataProvider licenseDataProvider
     *
     * @param mixed $expected
     */
    public function testLicenseToJson(License $license, $expected): void
    {
        $serializer = new JsonSerializer($this->createMock(SpecInterface::class));
        $data = $serializer->licenseToJson($license);
        self::assertEquals($expected, $data);
    }

    /**
     * @return Generator<string, array{0:License, 1:array}>
     */
    public function licenseDataProvider(): Generator
    {
        $name = $this->getRandomString();
        $license = $this->createStub(License::class);
        $license->method('getName')->willReturn($name);
        $expected = ['name' => $name];
        yield 'withName' => [$license, $expected];

        $id = $this->getRandomString();
        $license = $this->createStub(License::class);
        $license->method('getId')->willReturn($id);
        $expected = ['id' => $id];
        yield 'withId' => [$license, $expected];

        $name = $this->getRandomString();
        $url = 'https://example.com/license/'.$this->getRandomString();
        $license = $this->createStub(License::class);
        $license->method('getUrl')->willReturn($url);
        $license->method('getName')->willReturn($name);
        $expected = ['name' => $name, 'url' => $url];
        yield 'withUrl' => [$license, $expected];
    }

    // endregion licenseToJson

    // region hashesToJson

    public function testHashesToJson(): void
    {
        $serializer = $this->createPartialMock(JsonSerializer::class, ['hashToJson']);

        $algorithm = $this->getRandomString();
        $content = $this->getRandomString();
        $hashToJsonFake = [$algorithm, $content];
        $expected = [$hashToJsonFake];
        $hash = $this->createStub(Hash::class);

        $serializer->method('hashToJson')
            ->with($hash)
            ->willReturn($hashToJsonFake);

        $serialized = iterator_to_array($serializer->hashesToJson([$hash]));

        self::assertEquals($expected, $serialized);
    }

    public function testHashesToJsonThrows(): void
    {
        $serializer = $this->createPartialMock(JsonSerializer::class, ['hashToJson']);

        $errorMessage = $this->getRandomString();
        $hash = $this->createStub(Hash::class);

        $serializer->method('hashToJson')
            ->with($hash)
            ->willThrowException(new DomainException($errorMessage));

        $this->expectWarning();
        $this->expectWarningMessageMatches('/skipped hash/i');
        $this->expectWarningMessageMatches('/'.preg_quote($errorMessage, '/').'/');

        iterator_to_array($serializer->hashesToJson([$hash]));
    }

    // endregion

    // region helpers

    private function getRandomString(int $length = 128): string
    {
        return bin2hex(random_bytes($length));
    }

    // endregion helpers
}
