<?php

// defined('ABSPATH') || exit;

class CM_Autoloader
{

	/**
	 * Path to the includes directory
	 * @var string
	 */
	private $include_path = '';

	public function __construct()
	{
		spl_autoload_register(array($this, 'class_codemeta_autoloader'));
		$this->include_path = untrailingslashit(plugin_dir_path(CM_META_FILE)) . '/includes/';
	}

	/**
	 * Include a class file.
	 *
	 * @param  string $path File path.
	 * @return bool Successful or not.
	 */
	private function load_file($path)
	{
		if ($path && is_readable($path)) {
			include_once $path;
			return true;
		}
		return false;
	}

	public function class_codemeta_autoloader($class)
	{

		$class = strtolower($class);
		if (0 !== strpos($class, 'codemilitant')) {
			return;
		}

		$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
		$class_base = pathinfo($class, PATHINFO_FILENAME);
		$file = 'class-' . str_replace('_', '-', $class_base) . '.php';

		$path = '';

		if ( strpos( $class, 'admin' ) !== false ) {
			$path = $this->include_path . 'admin/';
		} elseif ( strpos( $class, 'templates' ) !== false ) {
			$path = $this->include_path . 'templates/';
		} else {
			$path = $this->include_path;
		}
		if (empty($path) || !$this->load_file($path . $file)) {
			$this->load_file($this->include_path . $file);
		}
	}
}
new CM_Autoloader();
