<?php

declare(strict_types=1);

namespace Pollen\ComingSoon\Adapters;

use Pollen\ComingSoon\Contracts\ComingSoonContract;
use Pollen\ComingSoon\Metabox\ComingSoonMetabox;
use tiFy\Support\Proxy\Metabox;

class WordpressAdapter extends AbstractOutdatedBrowserAdapter
{
    /**
     * @param ComingSoonContract $comingSoonManager
     */
    public function __construct(ComingSoonContract $comingSoonManager)
    {
        parent::__construct($comingSoonManager);

        add_action('init', function () {
            if ($config = config('tb-set.coming-soon', true)) {
                $defaults = [
                    'admin'   => false,
                    'offline' => 'off',
                ];

                config([
                           'tb-set.coming-soon' => is_array($config) ? array_merge($defaults, $config) : $defaults
                       ]);

                if ($admin = config('tb-set.coming-soon.admin')) {
                    $defaults = [
                        'name' => 'coming_soon',
                        'value' => get_option('coming_soon') ? : config('tb-set.coming-soon.offline', 'off')
                    ];

                    $attrs = is_array($admin) ? array_merge($defaults, $admin) : $defaults;

                    Metabox::add('coming-soon', array_merge($attrs, [
                        'driver' => new ComingSoonMetabox()
                    ]))->setScreen('tify_options@options')->setContext('tab');
                }
            }
        });

        add_action('template_redirect', function () {
            $offline = get_option('coming_soon') ? : config('tb-set.coming-soon.offline', 'off');

            if (($offline === 'on') && !is_user_logged_in()) {
                wp_die(
                    __('Ce site est actuellement en cours de construction.', 'tify'),
                    __('Site en construction', 'tify'),
                    500
                );
            }
        }, 0);
    }
}
