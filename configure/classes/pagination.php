<?php

/**
 * Paginationクラス拡張
 *
 * @author sakairi@liz-inc.co.jp
 *
 */
class Pagination extends Fuel\Core\Pagination {

    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Pagination::first()
     */
    public function first($marker = null) {
        $html = '';

        $marker === null and $marker = $this->template['first-marker'];

        if ($this->config['show_first']) {
            if (1 < $this->config['total_pages'] and 1 < $this->config['calculated_page']) {
                $html = str_replace('{link}',
//                     str_replace(array('{uri}', '{page}'), array($this->_make_link(1), $marker), $this->template['first-link']),
                    str_replace(['{uri}', '{page}'], [$this->_make_link(1), 1], $this->template['first-link']),
                    $this->template['first']);
                $this->raw_results['first'] = ['uri' => $this->_make_link(1), 'title' => $marker, 'type' => 'first'];
            } else {
                $html = str_replace('{link}',
                    str_replace(['{uri}', '{page}'], ['#', $marker], $this->template['first-inactive-link']),
                    $this->template['first-inactive']);
                $this->raw_results['first'] = ['uri' => '#', 'title' => $marker, 'type' => 'first-inactive'];
            }
        }

        return $html;
    }

    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Pagination::previous()
     */
    public function previous($marker = null) {
        $html = '';

        $marker === null and $marker = $this->template['previous-marker'];

        if (1 < $this->config['total_pages']) {
            if ($this->config['calculated_page'] == 1) {
                $html = str_replace('{link}',
                    str_replace(['{uri}', '{page}'], ['#', $marker], $this->template['previous-inactive-link']),
                    $this->template['previous-inactive']);
                $this->raw_results['previous'] = ['uri' => '#', 'title' => $marker, 'type' => 'previous-inactive'];
            } else {
                $previous_page = $this->config['calculated_page'] - 1;
                $previous_page = ($previous_page == 1) ? '' : $previous_page;

                $html = str_replace('{link}',
//                     str_replace(array('{uri}', '{page}'), array($this->_make_link($previous_page), $marker), $this->template['previous-link']),
                    str_replace(['{uri}', '{page}'], [$this->_make_link($previous_page), $previous_page], $this->template['previous-link']),
                    $this->template['previous']);
                $this->raw_results['previous'] = ['uri' => $this->_make_link($previous_page), 'title' => $marker, 'type' => 'previous'];
            }
        }

        return $html;
    }

    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Pagination::next()
     */
    public function next($marker = null) {
        $html = '';

        $marker === null and $marker = $this->template['next-marker'];

        if (1 < $this->config['total_pages']) {
            if ($this->config['calculated_page'] == $this->config['total_pages']) {
                $html = str_replace('{link}',
                    str_replace(['{uri}', '{page}'], ['#', $marker], $this->template['next-inactive-link']),
                    $this->template['next-inactive']);
                $this->raw_results['next'] = ['uri' => '#', 'title' => $marker, 'type' => 'next-inactive'];
            } else {
                $next_page = $this->config['calculated_page'] + 1;

                $html = str_replace('{link}',
//                     str_replace(array('{uri}', '{page}'), array($this->_make_link($next_page), $marker), $this->template['next-link']),
                    str_replace(['{uri}', '{page}'], [$this->_make_link($next_page), $next_page], $this->template['next-link']),
                    $this->template['next']);
                $this->raw_results['next'] = ['uri' => $this->_make_link($next_page), 'title' => $marker, 'type' => 'next'];
            }
        }

        return $html;
    }

    /**
     * {@inheritDoc}
     *
     * @see \Fuel\Core\Pagination::last()
     */
    public function last($marker = null) {
        $html = '';

        $marker === null and $marker = $this->template['last-marker'];

        if ($this->config['show_last']) {
            if (1 < $this->config['total_pages'] and $this->config['calculated_page'] != $this->config['total_pages']) {
                $html = str_replace('{link}',
//                     str_replace(array('{uri}', '{page}'), array($this->_make_link($this->config['total_pages']), $marker), $this->template['last-link']),
                    str_replace(['{uri}', '{page}'], [$this->_make_link($this->config['total_pages']), $this->config['total_pages']], $this->template['last-link']),
                    $this->template['last']);
                $this->raw_results['last'] = ['uri' => $this->_make_link($this->config['total_pages']), 'title' => $marker, 'type' => 'last'];
            } else {
                $html = str_replace('{link}',
                    str_replace(['{uri}', '{page}'], ['#', $marker], $this->template['last-inactive-link']),
                    $this->template['last-inactive']);
                $this->raw_results['last'] = ['uri' => '#', 'title' => $marker, 'type' => 'last-inactive'];
            }
        }

        return $html;
    }
}