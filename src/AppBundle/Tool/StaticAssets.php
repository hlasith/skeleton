<?php
/**
 * Created by PhpStorm.
 * User: ZhaWa
 * Date: 25.06.2018
 * Time: 13:45
 */

namespace AppBundle\Tool;


use Pimcore\Logger;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class StaticAssets
{

    public static function getJsPaths()
    {
        if (\Pimcore::getContainer()->hasParameter('main.js.minified.hash')) {
            $hash = \Pimcore::getContainer()->getParameter('main.js.minified.hash');
            if (!empty($hash)) {
                return [sprintf('/static/js/%s.ngl-min.js', $hash)];
            }
        }
        return ['/static/node_modules/requirejs/require.js', '/static/js/main.js'];
    }

    public static function getCssStylesPath()
    {
        if (\Pimcore::getContainer()->hasParameter('main.css.minified.hash.styles')) {
            $hash = \Pimcore::getContainer()->getParameter('main.css.minified.hash.styles');
            if (!empty($hash)) {
                return sprintf('/static/css/%s.styles.css', $hash);
            }
        }
       return '/static/css/styles.css';
    }

    public static function getCssStylesContentPath()
    {
        if (\Pimcore::getContainer()->hasParameter('main.css.minified.hash.styles-content')) {
            $hash = \Pimcore::getContainer()->getParameter('main.css.minified.hash.styles-content');
            if (!empty($hash)) {
                return sprintf('/static/css/%s.styles-content.css', $hash);
            }
        }
        return '/static/css/styles-content.css';
    }

    public static function configureJsMinified(ContainerBuilder $container)
    {

        if ($container->hasParameter('main.js.minified.enable')) {
            $enableJsMinified = $container->getParameter('main.js.minified.enable');
        } else {
            if ('dev' === $container->getParameter('kernel.environment')) {
                $enableJsMinified = false;
            } else {
                $enableJsMinified = true;
            }
            $container->setParameter('main.js.minified.enable', $enableJsMinified);
        }
        if ($enableJsMinified) {
            $minifiedJsHash = str_replace('.ngl-min.js', '', self::getFilename('*.ngl-min.js', PIMCORE_WEB_ROOT . '/static/js'));
            $container->setParameter('main.js.minified.hash', $minifiedJsHash);
        }
    }

    public static function configureCssMinified(ContainerBuilder $container)
    {
        if ($container->hasParameter('main.css.minified.enable')) {
            $enableCssMinified = $container->getParameter('main.css.minified.enable');
        } else {
            if ('dev' === $container->getParameter('kernel.environment')) {
                $enableCssMinified = false;
            } else {
                $enableCssMinified = true;
            }
            $container->setParameter('main.css.minified.enable', $enableCssMinified);
        }
        if ($enableCssMinified) {
            $minifiedCssStylesHash = str_replace('.styles.css', '', self::getFilename('*.styles.css', PIMCORE_WEB_ROOT . '/static/css'));
            $container->setParameter('main.css.minified.hash.styles', $minifiedCssStylesHash);
            $minifiedCssStylesContentHash = str_replace('.styles-content.css', '', self::getFilename('*.styles-content.css', PIMCORE_WEB_ROOT . '/static/css'));
            $container->setParameter('main.css.minified.hash.styles-content', $minifiedCssStylesContentHash);
        }
    }

    private static function getFilename(string $pattern, string $dir)
    {
        if (is_dir($dir)) {
            $fullPattern = $dir . '/' . $pattern;
            $files = glob($fullPattern);
            if (empty($files)) {
                Logger::warning(sprintf("Can not get hash for pattern %s in folder %s", $pattern, $dir));
                return "";
            } else if (count($files)) {
                Logger::warning(sprintf("Multiple hash found for pattern %s in folder %s. Taken first one: %s", $pattern, $dir, $files[0]));
                $fullFilename = $files[0];
            } else {
                $fullFilename = $files[0];
            }
            return substr($fullFilename, strrpos($fullFilename, DIRECTORY_SEPARATOR) + 1);

        }
    }
}