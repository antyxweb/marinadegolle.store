<?php

/*
* The MIT License
*
* Copyright (c) 2024 "YooMoney", NBСO LLC
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/

namespace Tests\YooKassa\Model\SelfEmployed;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use YooKassa\Helpers\Random;
use YooKassa\Model\SelfEmployed\SelfEmployedConfirmation;
use YooKassa\Model\SelfEmployed\SelfEmployedConfirmationFactory;
use YooKassa\Model\SelfEmployed\SelfEmployedConfirmationType;

/**
 * ConfirmationFactoryTest
 *
 * @category    ClassTest
 * @author      cms@yoomoney.ru
 * @link        https://yookassa.ru/developers/api
 */
class ConfirmationFactoryTest extends TestCase
{
    /**
     * @dataProvider validTypeDataProvider
     */
    public function testFactory(string $type): void
    {
        $instance = $this->getTestInstance();
        $confirmation = $instance->factory($type);
        self::assertNotNull($confirmation);
        self::assertInstanceOf(SelfEmployedConfirmation::class, $confirmation);
        self::assertEquals($type, $confirmation->getType());
    }

    /**
     * @dataProvider invalidFactoryDataProvider
     *
     * @param mixed $type
     */
    public function testInvalidFactory($type): void
    {
        $this->expectException(InvalidArgumentException::class);
        $instance = $this->getTestInstance();
        $instance->factory($type);
    }

    /**
     * @dataProvider validArrayDataProvider
     */
    public function testFactoryFromArray(array $options): void
    {
        $instance = $this->getTestInstance();
        $confirmation = $instance->factoryFromArray($options);
        self::assertNotNull($confirmation);
        self::assertInstanceOf(SelfEmployedConfirmation::class, $confirmation);

        foreach ($options as $property => $value) {
            self::assertEquals($confirmation->{$property}, $value);
        }

        $type = $options['type'];
        unset($options['type']);
        $confirmation = $instance->factoryFromArray($options, $type);
        self::assertNotNull($confirmation);
        self::assertInstanceOf(SelfEmployedConfirmation::class, $confirmation);

        self::assertEquals($type, $confirmation->getType());
        foreach ($options as $property => $value) {
            self::assertEquals($confirmation->{$property}, $value);
        }
    }

    /**
     * @dataProvider invalidDataArrayDataProvider
     *
     * @param mixed $options
     */
    public function testInvalidFactoryFromArray($options): void
    {
        $this->expectException(InvalidArgumentException::class);
        $instance = $this->getTestInstance();
        $instance->factoryFromArray($options);
    }

    public static function validTypeDataProvider(): array
    {
        $result = [];
        foreach (SelfEmployedConfirmationType::getValidValues() as $value) {
            $result[] = [$value];
        }

        return $result;
    }

    public static function invalidFactoryDataProvider(): array
    {
        return [
            [''],
            ['123'],
            ['test'],
        ];
    }

    public static function invalidTypeDataProvider(): array
    {
        return [
            [''],
            [null],
            [0],
            [1],
            [-1],
            ['5'],
            [[]],
            [new stdClass()],
            [Random::str(10)],
        ];
    }

    public static function validArrayDataProvider(): array
    {
        $result = [
            [
                [
                    'type' => SelfEmployedConfirmationType::REDIRECT,
                    'confirmationUrl' => 'https://' . Random::str(1, 10, 'abcdefghijklmnopqrstuvwxyz') . '.com',
                ]
            ],
            [
                [
                    'type' => SelfEmployedConfirmationType::REDIRECT,
                    'confirmationUrl' => 'https://' . Random::str(1, 10, 'abcdefghijklmnopqrstuvwxyz') . '.ru',
                ],
            ],
            [
                [
                    'type' => SelfEmployedConfirmationType::REDIRECT,
                    'confirmationUrl' => 'https://' . Random::str(1, 10, 'abcdefghijklmnopqrstuvwxyz') . '.en',
                ],
            ],
            [
                [
                    'type' => SelfEmployedConfirmationType::REDIRECT,
                ],
            ],
            [
                [
                    'type' => SelfEmployedConfirmationType::REDIRECT,
                ],
            ],
            [
                [
                    'type' => SelfEmployedConfirmationType::REDIRECT,
                ],
            ],
        ];
        foreach (SelfEmployedConfirmationType::getValidValues() as $value) {
            $result[] = [['type' => $value]];
        }

        return $result;
    }

    public static function invalidDataArrayDataProvider(): array
    {
        return [
            [[]],
            [['type' => 'test']],
        ];
    }

    protected function getTestInstance(): SelfEmployedConfirmationFactory
    {
        return new SelfEmployedConfirmationFactory();
    }
}
