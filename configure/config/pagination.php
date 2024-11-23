<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */

return [

    // the active pagination template
    'active'     => 'bootstrap3',

    // default FuelPHP pagination template, compatible with pre-1.4 applications
    'default'    => [
        'wrapper' => "<div class=\"pagination\">\n\t{pagination}\n</div>\n",

        'first'        => "<span class=\"first\">\n\t{link}\n</span>\n",
        'first-marker' => "&laquo;&laquo;",
        'first-link'   => "\t\t<a href=\"{uri}\">{page}</a>\n",

        'first-inactive'      => "",
        'first-inactive-link' => "",

        'previous'        => "<span class=\"previous\">\n\t{link}\n</span>\n",
        'previous-marker' => "&laquo;",
        'previous-link'   => "\t\t<a href=\"{uri}\" rel=\"prev\">{page}</a>\n",

        'previous-inactive'      => "<span class=\"previous-inactive\">\n\t{link}\n</span>\n",
        'previous-inactive-link' => "\t\t<a href=\"#\" rel=\"prev\">{page}</a>\n",

        'regular'      => "<span>\n\t{link}\n</span>\n",
        'regular-link' => "\t\t<a href=\"{uri}\">{page}</a>\n",

        'active'      => "<span class=\"active\">\n\t{link}\n</span>\n",
        'active-link' => "\t\t<a href=\"#\">{page}</a>\n",

        'next'        => "<span class=\"next\">\n\t{link}\n</span>\n",
        'next-marker' => "&raquo;",
        'next-link'   => "\t\t<a href=\"{uri}\" rel=\"next\">{page}</a>\n",

        'next-inactive'      => "<span class=\"next-inactive\">\n\t{link}\n</span>\n",
        'next-inactive-link' => "\t\t<a href=\"#\" rel=\"next\">{page}</a>\n",

        'last'        => "<span class=\"last\">\n\t{link}\n</span>\n",
        'last-marker' => "&raquo;&raquo;",
        'last-link'   => "\t\t<a href=\"{uri}\">{page}</a>\n",

        'last-inactive'      => "",
        'last-inactive-link' => "",
    ],

    // Twitter bootstrap 3.x template
    'bootstrap3' => [
        'wrapper' => "<ul class=\"pagination\">\n\t{pagination}\n\t</ul>\n",

        'first'        => "\n\t\t<li>{link}</li>",
        'first-marker' => "&laquo;&laquo;",
// 		'first-link'              => "<a href=\"{uri}\">{page}</a>",
        'first-link'   => "<a href=\"javascript:void(0);\" onclick=\"forward_page(1)\">&laquo;&laquo;</a>",

        'first-inactive'      => "",
        'first-inactive-link' => "",

        'previous'        => "\n\t\t<li>{link}</li>",
        'previous-marker' => "&laquo;",
// 		'previous-link'           => "<a href=\"{uri}\" rel=\"prev\">{page}</a>",
        'previous-link'   => "<a href=\"javascript:void(0);\" rel=\"prev\" onclick=\"forward_page({page})\">&laquo;</a>",

        'previous-inactive'      => "\n\t\t<li class=\"disabled\">{link}</li>",
// 		'previous-inactive-link'  => "<a href=\"#\" rel=\"prev\">{page}</a>",
        'previous-inactive-link' => "<a rel=\"prev\">{page}</a>",

        'regular'      => "\n\t\t<li>{link}</li>",
//		'regular-link'            => "<a href=\"{uri}\">{page}</a>",
        'regular-link' => "<a href=\"javascript:void(0);\" onclick=\"forward_page({page})\">{page}</a>",

        'active'      => "\n\t\t<li class=\"active\">{link}</li>",
// 		'active-link'             => "<a href=\"#\">{page} <span class=\"sr-only\"></span></a>",
        'active-link' => "<a>{page} <span class=\"sr-only\"></span></a>",

        'next'        => "\n\t\t<li>{link}</li>",
        'next-marker' => "&raquo;",
//		'next-link'               => "<a href=\"{uri}\" rel=\"next\">{page}</a>",
        'next-link'   => "<a href=\"javascript:void(0);\" rel=\"next\" onclick=\"forward_page({page})\">&raquo;</a>",

        'next-inactive'      => "\n\t\t<li class=\"disabled\">{link}</li>",
// 		'next-inactive-link'      => "<a href=\"#\" rel=\"next\">{page}</a>",
        'next-inactive-link' => "<a rel=\"next\">{page}</a>",

        'last'        => "\n\t\t<li>{link}</li>",
        'last-marker' => "&raquo;&raquo;",
// 		'last-link'               => "<a href=\"{uri}\">{page}</a>",
        'last-link'   => "<a href=\"javascript:void(0);\" onclick=\"forward_page({page})\">&raquo;&raquo;</a>",

        'last-inactive'      => "",
        'last-inactive-link' => "",
    ],

    // Twitter bootstrap 2.x template
    'bootstrap'  => [
        'wrapper' => "<div class=\"pagination\">\n\t<ul>{pagination}\n\t</ul>\n</div>\n",

        'first'        => "\n\t\t<li>{link}</li>",
        'first-marker' => "&laquo;&laquo;",
        'first-link'   => "<a href=\"{uri}\">{page}</a>",

        'first-inactive'      => "",
        'first-inactive-link' => "",

        'previous'        => "\n\t\t<li>{link}</li>",
        'previous-marker' => "&laquo;",
        'previous-link'   => "<a href=\"{uri}\" rel=\"prev\">{page}</a>",

        'previous-inactive'      => "\n\t\t<li class=\"disabled\">{link}</li>",
        'previous-inactive-link' => "<a href=\"#\" rel=\"prev\">{page}</a>",

        'regular'      => "\n\t\t<li>{link}</li>",
        'regular-link' => "<a href=\"{uri}\">{page}</a>",

        'active'      => "\n\t\t<li class=\"active\">{link}</li>",
        'active-link' => "<a href=\"#\">{page}</a>",

        'next'        => "\n\t\t<li>{link}</li>",
        'next-marker' => "&raquo;",
        'next-link'   => "<a href=\"{uri}\" rel=\"next\">{page}</a>",

        'next-inactive'      => "\n\t\t<li class=\"disabled\">{link}</li>",
        'next-inactive-link' => "<a href=\"#\" rel=\"next\">{page}</a>",

        'last'        => "\n\t\t<li>{link}</li>",
        'last-marker' => "&raquo;&raquo;",
        'last-link'   => "<a href=\"{uri}\">{page}</a>",

        'last-inactive'      => "",
        'last-inactive-link' => "",
    ],

    'mypage_contract' => [
        'pagination_url' => Uri::create('mypage/contract/?'),
        'uri_segment'    => 3,
        'num_links'      => 7,
        'per_page'       => 10,
    ],

];
