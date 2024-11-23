<?php

/**
 * Override \Fuel\Core\Database_PDO_Connection
 * Oracle接続用にオーバーライド
 *
 * @extends  \Fuel\Core\Database_PDO_Connection
 * @author sakairi@liz-inc.co.jp
 */
class Database_PDO_Connection extends \Fuel\Core\Database_PDO_Connection {

    /**
     * Set the charset
     *
     * @param string $charset
     */
    public function set_charset($charset) {
        // Make sure the database is connected
        $this->_connection or $this->connect();

        // Set Charset for SQL Server connection
        if (strtolower($this->driver_name()) == 'sqlsrv') {
            $this->_connection->setAttribute(\PDO::SQLSRV_ATTR_ENCODING, \PDO::SQLSRV_ENCODING_SYSTEM);
        }        // Set Charset for SQLite connection
        elseif (strtolower($this->driver_name()) == 'sqlite') {
            // Execute a raw PRAGMA encoding query
            $this->_connection->exec('PRAGMA encoding = ' . $this->quote($charset));
        }        // Set Charset for any connection except ODBC, as it throws exception
        elseif (strtolower($this->driver_name()) != 'odbc') {
            // Execute a raw SET NAMES query
            // $this->_connection->exec('SET NAMES '.$this->quote($charset));
        }
    }

    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Database_PDO_Connection::query()
     */
    public function query($type, $sql, $as_object) {
        // Make sure the database is connected
        $this->_connection or $this->connect();

        if (\Fuel::$profiling and !empty($this->_config['profiling'])) {
            // Get the paths defined in config
            $paths = \Config::get('profiling_paths');

            // Storage for the trace information
            $stacktrace = [];

            // Get the execution trace of this query
            $include = false;
            foreach (debug_backtrace() as $index => $page) {
                // Skip first entry and entries without a filename
                if ($index > 0 and empty($page['file']) === false) {
                    // Checks to see what paths you want backtrace
                    foreach ($paths as $index => $path) {
                        if (strpos($page['file'], $path) !== false) {
                            $include = true;
                            break;
                        }
                    }

                    // Only log if no paths we defined, or we have a path match
                    if ($include or empty($paths)) {
                        $stacktrace[] = ['file' => \Fuel::clean_path($page['file']), 'line' => $page['line']];
                    }
                }
            }

            $benchmark = \Profiler::start($this->_instance, $sql, $stacktrace);
        }

        // run the query. if the connection is lost, try 3 times to reconnect
        $attempts = 3;

        do {
            try {
                // try to run the query
                $result = $this->_connection->query($sql);
                break;
            } catch (\Exception $e) {
                // if failed and we have attempts left
                if ($attempts > 0) {
                    // try reconnecting if it was a MySQL disconnected error
                    if (strpos($e->getMessage(), '2006 MySQL') !== false) {
                        $this->disconnect();
                        $this->connect();
                    } else {
                        // other database error, cleanup the profiler
                        isset($benchmark) and \Profiler::delete($benchmark);

                        // and convert the exception in a database exception
                        if (!is_numeric($error_code = $e->getCode())) {
                            if ($this->_connection) {
                                $error_code = $this->_connection->errorinfo();
                                $error_code = $error_code[1];
                            } else {
                                $error_code = 0;
                            }
                        }

                        throw new \Database_Exception($e->getMessage() . ' with query: "' . $sql . '"', $error_code, $e);
                    }
                } else {
                    // no more attempts left, bail out
                    // and convert the exception in a database exception
                    if (!is_numeric($error_code = $e->getCode())) {
                        if ($this->_connection) {
                            $error_code = $this->_connection->errorinfo();
                            $error_code = $error_code[1];
                        } else {
                            $error_code = 0;
                        }
                    }
                    throw new \Database_Exception($e->getMessage() . ' with query: "' . $sql . '"', $error_code, $e);
                }
            }
        } while ($attempts-- > 0);

        if (isset($benchmark)) {
            \Profiler::stop($benchmark);
        }

        // Set the last query
        $this->last_query = $sql;

        if ($type === \DB::SELECT) {
            // Convert the result into an array, as PDOStatement::rowCount is not reliable
            if ($as_object === false) {
                $result = $result->fetchAll(\PDO::FETCH_ASSOC);
            } elseif (is_string($as_object)) {
                $result = $result->fetchAll(\PDO::FETCH_CLASS, $as_object);
            } else {
                $result = $result->fetchAll(\PDO::FETCH_CLASS, 'stdClass');
            }

            // Return an iterator of results
            return new \Database_Result_Cached($result, $sql, $as_object);
        } elseif ($type === \DB::INSERT) {
            // Return a list of insert id and rows created
            if (strtolower($this->driver_name()) == 'oci') {
                // オラクルの場合
                return $result->rowCount();
            } else {
                return [
                    $this->_connection->lastInsertId(),
                    $result->rowCount(),
                ];
            }
        } elseif ($type === \DB::UPDATE or $type === \DB::DELETE) {
            // Return the number of rows affected
            return $result->errorCode() === '00000' ? $result->rowCount() : -1;
        }

        return $result->errorCode() === '00000' ? true : false;
    }
}
