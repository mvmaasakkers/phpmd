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

namespace PHPMD\Integration;

use PHPMD\AbstractTest;
use PHPMD\TextUI\Command;

/**
 * Integration tests for the coupling between objects rule class.
 *
 * @author Manuel Pichler <mapi@phpmd.org>
 * @copyright 2008-2017 Manuel Pichler. All rights reserved.
 * @license https://www.opensource.org/licenses/bsd-license.php BSD License
 * @since      1.1.0
 *
 * @group phpmd
 * @group phpmd::integration
 * @group integrationtest
 */
class CouplingBetweenObjectsIntegrationTest extends AbstractTest
{
    /**
     * testReportContainsCouplingBetweenObjectsWarning
     *
     * @return void
     * @outputBuffering enabled
     */
    public function testReportContainsCouplingBetweenObjectsWarning()
    {
        $file = self::createTempFileUri();

        Command::main(
            array(
                __FILE__,
                $this->createCodeResourceUriForTest(),
                'text',
                'design',
                '--reportfile',
                $file
            )
        );

        self::assertContains(
            'has a coupling between objects value of 14. ' .
            'Consider to reduce the number of dependencies under 13.',
            file_get_contents($file)
        );
    }
}
