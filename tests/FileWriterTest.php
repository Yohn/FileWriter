<?php

namespace Yohns\Util\Tests;

use PHPUnit\Framework\TestCase;
use Yohns\Util\FileWriter;

class FileWriterTest extends TestCase {
	private string $testFilePath;

	protected function setUp(): void {
		$this->testFilePath = sys_get_temp_dir() . '/filewriter_test_' . uniqid() . '.txt';
	}

	protected function tearDown(): void {
		if (file_exists($this->testFilePath)) {
			unlink($this->testFilePath);
		}
	}

	public function testConstructorCreatesDirectoryIfNotExists(): void {
		$nestedPath = sys_get_temp_dir() . '/test_nested_dir_' . uniqid() . '/file.txt';
		$fileWriter = new FileWriter($nestedPath);

		$this->assertFileExists(dirname($nestedPath), 'Directory should be created');
	}

	public function testOverwriteCreatesFileWithContent(): void {
		$fileWriter = new FileWriter($this->testFilePath);
		$content = "Test overwrite content\n";

		$result = $fileWriter->overwrite($content);

		$this->assertTrue($result, 'Overwrite should return true');
		$this->assertFileExists($this->testFilePath, 'File should exist after overwrite');
		$this->assertStringEqualsFile($this->testFilePath, $content, 'File content should match');
	}

	public function testAppendAddsContentToFile(): void {
		$fileWriter = new FileWriter($this->testFilePath);

		$fileWriter->overwrite("Initial content\n");
		$result = $fileWriter->append("Appended content\n");

		$this->assertTrue($result, 'Append should return true');
		$expectedContent = "Initial content\nAppended content\n";
		$this->assertStringEqualsFile($this->testFilePath, $expectedContent, 'File should contain both contents');
	}

	public function testPrependAddsContentToBeginningOfFile(): void {
		$fileWriter = new FileWriter($this->testFilePath);

		$fileWriter->overwrite("Initial content\n");
		$result = $fileWriter->prepend("Prepended content\n");

		$this->assertTrue($result, 'Prepend should return true');
		$expectedContent = "Prepended content\nInitial content\n";
		$this->assertStringEqualsFile($this->testFilePath, $expectedContent, 'File should have prepended content');
	}

	public function testMultipleOperationsOnSameFile(): void {
		$fileWriter = new FileWriter($this->testFilePath);

		$fileWriter->overwrite("First line\n");
		$fileWriter->append("Second line\n");
		$fileWriter->prepend("Zero line\n");

		$expectedContent = "Zero line\nFirst line\nSecond line\n";
		$this->assertStringEqualsFile($this->testFilePath, $expectedContent, 'File should reflect all operations');
	}

	public function testWriteToNonWritableDirectory(): void {
		// This test requires root/sudo access to create a truly non-writable directory
		// Skipping due to environment constraints
		$this->markTestSkipped('Requires root access to test non-writable directory scenario');
	}
}