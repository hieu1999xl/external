<?php

/**
 * ファイル関連のヘルパークラス
 *
 * @author akiyama.k
 */
class Helper_File {
    /**
     * 引数のパスのディレクトリが存在するか否か
     *
     * @param string $path
     * @return bool
     */
    public static function is_exist_dir($path) {
        if (!file_exists($path)) {
            return false;
        }
        return is_dir($path);
    }

    /**
     * 引数のパスのファイルが存在するか否か
     *
     * @param string $path
     * @return bool
     */
    public static function is_exist_file($path) {
        if (!file_exists($path)) {
            return false;
        }
        return is_file($path);
    }

    /**
     * 引数の値を元にディレクトリを作成する
     *
     * @param string $path
     * @param int    $permission
     * @return bool
     */
    public static function create_dir($path, $permission = DIRECTORY_PERMISSION) {
        if (self::is_exist_dir($path)) {
            return true;
        }
        $mask = umask();
        umask(000);

        $result = false;
        try
        {
            $result = mkdir($path, $permission, true);
        }
        catch (\Exception $e)
        {
            Log::application()->error($e->getMessage());
        }

        umask($mask);
        return $result;
    }

    /**
     * 引数の値を元にファイルを作成する
     *
     * @param string $path
     * @param string $contents
     * @param int    $permission
     * @return bool
     */
    public static function create_file($path, $contents, $permission = FILE_PERMISSION) {
        if (!self::create_dir(dirname($path))) {
            return false;
        }
        if (file_put_contents($path, $contents) === false) {
            return false;
        }
        return chmod($path, $permission);
    }

    /**
     * 引数のパスのディレクトリを削除する
     *
     * @param string $path
     * @return bool
     */
    public static function delete_dir($path) {
        if (!self::is_exist_dir($path)) {
            return true;
        }

        if ($handle = opendir($path)) {
            while (($entry = readdir($handle)) !== false) {
                if ($entry != "." && $entry != "..") {
                    if (is_dir("$path/$entry")) {
                        self::delete_dir("$path/$entry");
                    } else {
                        unlink("$path/$entry");
                    }
                }
            }
        }

        closedir($handle);
        return rmdir($path);
    }

    /**
     * 引数のパスのファイルを削除する
     *
     * @param string $path
     * @return bool
     */
    public static function delete_file($path) {
        if (!self::is_exist_file($path)) {
            return true;
        }
        return unlink($path);
    }
}
