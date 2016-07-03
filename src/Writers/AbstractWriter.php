<?php
namespace michaeljamesparsons\DataImporter\Writers;

/**
 * Class AbstractWriter
 * @package michaeljamesparsons\DataImporter\Writers
 */
abstract class AbstractWriter
{
	/**
	 * Import a single item.
	 *
	 * @param array $item   - The item to import.
	 */
	public function write(array $item) {}

	/**
	 * Prepare writer before the import begins.
	 *
	 * Used to perform tasks and set conditions that must be completed in order for
	 * the writer to properly write each item.
	 */
	public function before() {}

	/**
	 * Shut down writer after import.
	 *
	 * Used to unset the conditions that required for the writer to function.
	 */
	public function after() {}
}