<?php

namespace Yohns\Util;

/**
 *
 * Class FileWriter
 *
 * Provides methods for writing content to a file with different modes.
 * // Example usage:
 * $fileWriter = new FileWriter('example/newfile.txt');
 *
 * // Overwrite file (create if it doesn't exist)
 * $fileWriter->overwrite("This will overwrite the file 2.\n");
 *
 * // Append to file (create if it doesn't exist)
 * $fileWriter->append("This will be appended to the file.\n");
 *
 * // Prepend to file (create if it doesn't exist)
 * $fileWriter->prepend("This will be prepended to the file.\n");
 */
class FileWriter {

	private string $filename;

	/**
	 * FileWriter constructor.
	 *
	 * @param string $filename The name of the file to write to.
	 */
	public function __construct(string $filename) {
		$this->filename = $filename;
		$this->ensureDirectoryExists(dirname($filename));
		$this->createIfNeeded();
	}

	/**
	 * Ensures that the directory for the given path exists.
	 *
	 * @param string $directory The directory path.
	 * @return bool True if directory exists or is created, false otherwise.
	 */
	private function ensureDirectoryExists(string $directory): bool {
		return is_dir($directory) || mkdir($directory, 0755, true);
	}

	/**
	 * Creates a new file with the given content if it doesn't exist.
	 *
	 * @return bool True if file exists or is created, false otherwise.
	 */
	private function createIfNeeded(): bool {
		return file_exists($this->filename) || $this->writeToFile('');
	}

	/**
	 * Overwrites the file with the given content.
	 *
	 * @param string $content The content to write.
	 * @return bool True on success, false on failure.
	 */
	public function overwrite(string $content): bool {
		if (!$this->createIfNeeded()) {
			return false;
		}
		return $this->writeToFile($content);
	}

	/**
	 * Appends the content to the end of the file.
	 *
	 * @param string $content The content to append.
	 * @return bool True on success, false on failure.
	 */
	public function append(string $content): bool {
		if (!$this->createIfNeeded()) {
			return false;
		}
		$currentContent = file_get_contents($this->filename);
		if ($currentContent === false) {
			return false;
		}
		return $this->writeToFile($currentContent . $content);
	}

	/**
	 * Prepends the content to the beginning of the file.
	 *
	 * @param string $content The content to prepend.
	 * @return bool True on success, false on failure.
	 */
	public function prepend(string $content): bool {
		if (!$this->createIfNeeded()) {
			return false;
		}
		$currentContent = file_get_contents($this->filename);
		if ($currentContent === false) {
			return false;
		}
		return $this->writeToFile($content . $currentContent);
	}

 /**
  * Deletes the file associated with the FileWriter instance.
  *
  * @return bool True if the file was successfully deleted, false if the file does not exist or could not be deleted.
  */
	public function delete(): bool {
		return file_exists($this->filename) ? unlink($this->filename) : false;
	}

	/**
	 * Writes content to the file using specified mode.
	 *
	 * @param string $content The content to write.
	 * @param string  The file write mode ('w' for overwrite, 'a' for append).
	 * @return bool True on success, false on failure.
	 */
	private function writeToFile(string $content): bool {
		return file_put_contents($this->filename, $content, LOCK_EX) !== false;
	}
}