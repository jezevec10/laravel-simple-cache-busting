<?php namespace Ruyter\CacheBusting;

class CacheBusting
{
    /**
    * Flag for if the package is enabled
    *
    * @var boolean
    */
    protected $enabled = false;

   /**
    * Config file name
    *
    * @var string
    */
    protected $configFile = 'cachebusting.php';

    /**
     * Asset cache busting hash
     *
     * @var string
     */
    protected $hash = null;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->setEnabled(config('cachebusting.enable'));

        $this->setHash(config('cachebusting.hash'));
    }

    /**
     * Enables / Disables the package
     *
     * @param boolean $enabled
     */
    public function setEnabled(bool $enabled = true): void
    {
        $this->enabled = (bool) $enabled;
    }

    /**
     * Sets the hash to bust the cache
     *
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        if (!preg_match("/[0-9a-f]{32}/", $hash)) {
            throw new \InvalidArgumentException("Cache busting hash must be a valid md5 hash.");
        }
        $this->hash = $hash;
    }

    /**
     * Returns the hash to bust the cache
     *
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * Generates an asset url
     *
     * @param string $path
     *
     * @return string $path
     */
    public function url(string $path = ''): string
    {
        if ($this->enabled) {
            return $path . '?' . $this->hash;
        } else {
            return $path;
        }
    }

    /**
     * Generate and save new hash
     *
     * @throws \Exception
     *
     * @return string
     */
    public function replaceHash(): string
    {
        $hash = $this->generateHash();

        $this->setHash($hash);

        $content = preg_replace(
            "/(?:hash.*=>\K.*(?:'|\")\K)[A-Za-z0-9]+/",
            $hash,
            $this->getConfigContent(),
            1,
            $count
        );
        if ($count != 1) {
            throw new \Exception("Could not find current hash key in config.");
        }

        if (!$this->setConfigContent($content)) {
            throw new \Exception("Could not write new hash in config file.");
        }

        return $hash;
    }

    /**
     * Generate new MD5 hash based on time
     *
     * @return string
     */
    protected function generateHash(): string
    {
        return md5(time());
    }

    /**
     * Get content from config file
     *
     * @return string
     */
    protected function getConfigContent(): string
    {
        return file_get_contents(config_path($this->configFile));
    }

    /**
     * Set content in the config file
     *
     * @return bool
     */
    protected function setConfigContent(string $content): bool
    {
        config(['cachebusting.hash' => $this->getHash()]);

        return (file_put_contents(config_path($this->configFile), $content) === false ? false : true);
    }
}
