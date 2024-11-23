<?php
/**
 * セッションファイルドライバー拡張クラス
 *
 * コンストラクト時にキャッシュディレクトリが存在しない場合は作成するように拡張する
 *
 * @author sakairi@liz-inc.co.jp
 * @see Fuel\Core\Session_File
 *
 */
class Session_File extends Fuel\Core\Session_File
{
    public function __construct($config = array())
    {
        // merge the driver config with the global config
        $this->config = array_merge($config, is_array($config['file']) ? $config['file'] : static::$_defaults);
        // セッションファイルを保持するディレクトリが存在しないときは作成する
        if (isset($this->config['path'])) {
            Helper_File::create_dir($this->config['path'], CACHE_DIRECTORY_PERMISSION);
        }
        $this->config = $this->_validate_config($this->config);
    }
}