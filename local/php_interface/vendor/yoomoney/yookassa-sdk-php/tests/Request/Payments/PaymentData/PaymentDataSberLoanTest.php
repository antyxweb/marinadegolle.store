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

namespace Tests\YooKassa\Request\Payments\PaymentData;

use Exception;
use Tests\YooKassa\AbstractTestCase;
use Datetime;
use YooKassa\Model\Metadata;
use YooKassa\Request\Payments\PaymentData\PaymentDataSberLoan;

/**
 * PaymentDataSberLoanTest
 *
 * @category    ClassTest
 * @author      cms@yoomoney.ru
 * @link        https://yookassa.ru/developers/api
 */
class PaymentDataSberLoanTest extends AbstractTestCase
{
    protected PaymentDataSberLoan $object;

    /**
     * @return PaymentDataSberLoan
     */
    protected function getTestInstance(): PaymentDataSberLoan
    {
        return new PaymentDataSberLoan();
    }

    /**
     * @return void
     */
    public function testPaymentDataSberLoanClassExists(): void
    {
        $this->object = $this->getMockBuilder(PaymentDataSberLoan::class)->getMockForAbstractClass();
        $this->assertTrue(class_exists(PaymentDataSberLoan::class));
        $this->assertInstanceOf(PaymentDataSberLoan::class, $this->object);
    }

    /**
     * Test property "type"
     *
     * @return void
     * @throws Exception
     */
    public function testType(): void
    {
        $instance = $this->getTestInstance();
        self::assertNotNull($instance->getType());
        self::assertNotNull($instance->type);
        self::assertContains($instance->getType(), ['sber_loan']);
        self::assertContains($instance->type, ['sber_loan']);
    }
}
