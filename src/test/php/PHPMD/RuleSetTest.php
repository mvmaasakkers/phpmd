<?php
/**
 * This file is part of PHP Mess Detector.
 *
 * Copyright (c) Manuel Pichler <mapi@phpmd.org>.
 * All rights reserved.
 *
 * Licensed under BSD License
 * For full copyright and license information, please see the LICENSE file.
 * Redistributions of files must retain the above copyright notice.
 *
 * @author Manuel Pichler <mapi@phpmd.org>
 * @copyright Manuel Pichler. All rights reserved.
 * @license https://www.opensource.org/licenses/bsd-license.php BSD License
 * @link http://phpmd.org/
 */

namespace PHPMD;

use PHPMD\Stubs\RuleStub;

/**
 * Test case for the {@link \PHPMD\RuleSet} class.
 *
 * @author Manuel Pichler <mapi@phpmd.org>
 * @copyright 2008-2017 Manuel Pichler. All rights reserved.
 * @license https://www.opensource.org/licenses/bsd-license.php BSD License
 *
 * @covers \PHPMD\RuleSet
 * @group phpmd
 * @group unittest
 */
class RuleSetTest extends AbstractTest
{
    /**
     * testGetRuleByNameReturnsNullWhenNoMatchingRuleExists
     *
     * @return void
     */
    public function testGetRuleByNameReturnsNullWhenNoMatchingRuleExists()
    {
        $ruleSet = $this->createRuleSetFixture();
        $this->assertNull($ruleSet->getRuleByName(__FUNCTION__));
    }

    /**
     * testGetRuleByNameReturnsMatchingRuleInstance
     *
     * @return void
     */
    public function testGetRuleByNameReturnsMatchingRuleInstance()
    {
        $ruleSet = $this->createRuleSetFixture(__FUNCTION__, __CLASS__, __METHOD__);
        $rule = $ruleSet->getRuleByName(__CLASS__);

        $this->assertEquals(__CLASS__, $rule->getName());
    }

    /**
     * testApplyNotInvokesRuleWhenSuppressAnnotationExists
     *
     * @return void
     */
    public function testApplyNotInvokesRuleWhenSuppressAnnotationExists()
    {
        $ruleSet = $this->createRuleSetFixture(__FUNCTION__);
        $ruleSet->setReport($this->getReportMock(0));
        $ruleSet->apply($this->getClass());

        $this->assertNull($ruleSet->getRuleByName(__FUNCTION__)->node);
    }

    /**
     * testApplyInvokesRuleWhenStrictModeIsSet
     *
     * @return void
     */
    public function testApplyInvokesRuleWhenStrictModeIsSet()
    {
        $ruleSet = $this->createRuleSetFixture(__FUNCTION__);
        $ruleSet->setReport($this->getReportMock(0));
        $ruleSet->setStrict();

        $class = $this->getClass();
        $ruleSet->apply($class);

        $this->assertSame($class, $ruleSet->getRuleByName(__FUNCTION__)->node);
    }

    /**
     * Creates a rule set instance with a variable amount of appended rule
     * objects.
     *
     * @return \PHPMD\AbstractRule
     */
    private function createRuleSetFixture()
    {
        $ruleSet = new RuleSet();
        for ($i = 0; $i < func_num_args(); ++$i) {
            $rule = new RuleStub(func_get_arg($i));

            $ruleSet->addRule($rule);
        }
        return $ruleSet;
    }
}
