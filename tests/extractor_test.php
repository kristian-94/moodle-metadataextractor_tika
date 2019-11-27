<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

use metadataextractor_tika\extractor;
use tool_metadata\mock_file_builder;

defined('MOODLE_INTERNAL') || die();

/**
 * Interface describing the strategy for extracting metadata from a Moodle stored_file resource.
 *
 * @package    metadataextractor_tika
 * @copyright  2019 Tom Dickman <tomdickman@catalyst-au.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class extractor_test extends advanced_testcase {

    public function setUp() {
        $this->resetAfterTest();
    }

    public function test_create_file_metadata_pdf() {
        global $CFG;

        // Skip if no valid FFProbe executable.
//        if (empty(get_config('metadata_extractor', 'pathtotika'))) {
//            $this->markTestSkipped('Test skipped as no valid tika-app jar file path set.');
//        }

        $file = mock_file_builder::mock_pdf();
        $extractor = new extractor();

        $result = $extractor->create_file_metadata($file);

        $metadata = $extractor->read_metadata($file->get_contenthash());

        $this->assertNotFalse($result);
        $this->assertEquals('This has been generated by Moodle.', $result->subject);
        $this->assertEquals('This has been generated by Moodle.', $result->description);
        $this->assertEquals('Moodle ' . $CFG->release, $result->creator);
        $this->assertEquals('This has been generated by Moodle.', $result->subject);
    }
}
