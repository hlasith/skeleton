<?php
/**
 * Created by PhpStorm.
 * User: ZhaWa
 * Date: 06.06.2018
 * Time: 12:21
 */

namespace AppBundle\Tool;

use AppBundle\Model\Document\NewsListing;
use Pimcore\Log\ApplicationLogger;
use Pimcore\Model\Document;
use Pimcore\Model\Document\Page;
use Pimcore\Model\Document\PageSnippet;
use Pimcore\Model\Document\Tag\Image;
use Pimcore\Model\Document\Tag\Input;
use Pimcore\Model\Document\Tag\Textarea;
use Pimcore\Model\Element\Tag;
use Pimcore\Model\User;

class NewsUtil
{
    /**
     * TODO translation!!
     * @param $dateTime
     * @return string
     */
    public static function getDateTimeToPresent($dateTime)
    {
        /** @var \DateInterval $interval */
        $interval = date_diff(date_create(), date_create($dateTime));
        $doPlural = function ($nb, $str) {
            if ($nb > 1) {
                switch ($str) {
                    case 'Jahr':
                    case 'Monat':
                    case 'Tag':
                        return $str . 'en';
                    case 'Stunde':
                    case 'Minute':
                    case 'Sekunde':
                        return $str . 'n';
                }
            } else
                return $str;
        };
        if (0 !== $interval->y) {
            return 'vor ' . $interval->y . ' ' . $doPlural($interval->y, 'Jahr');
        } else if (0 !== $interval->m) {
            return 'vor ' . $interval->m . ' ' . $doPlural($interval->m, 'Monat');
        } else if (0 !== $interval->d) {
            return 'vor ' . $interval->d . ' ' . $doPlural($interval->d, 'Tag');
        } else if (0 !== $interval->h) {
            return 'vor ' . $interval->h . ' ' . $doPlural($interval->h, 'Stunde');
        } else if (0 !== $interval->i) {
            return 'vor ' . $interval->i . ' ' . $doPlural($interval->i, 'Minute');
        } else {
            return 'vor ' . $interval->s . ' ' . $doPlural($interval->s, 'Sekunde');
        }
    }

    /**
     * @param Page $news
     * @return null|Image
     * @throws \Exception
     */
    public static function getTeaserImage($news)
    {
        if (!self::isNewsPage($news)) {
            $exception = new \Exception("Can not identify the news page");
            ApplicationLogger::getInstance()->logException(__METHOD__, $exception, 'error', $news);
            return null;
        }
        /** @var Image|null $image */
        $image = $news->getElement('news_teaser_image');
        if (empty($image) || empty($image->getImage())) {
            $image = $news->getElement('news_image');
        }
        if (empty($image) || empty($image->getImage())) {
            return null;
        }
        return $image;
    }

    /**
     * @param Page $news
     * @param int $limit
     * @return string
     * @throws \Exception
     */
    public static function getShortIntroduction($news, int $limit)
    {
        if (!self::isNewsPage($news)) {
            $exception = new \Exception("Can not identify the news page");
            ApplicationLogger::getInstance()->logException(__METHOD__, $exception, 'error', $news);
            return "";
        }

        /** @var Input|Textarea $newsIntroduction */
        $newsIntroduction = $news->getElement('news_introduction');
        if (empty($newsIntroduction) || empty($newsIntroduction->getData())) {
            $fullShortIntroduction = trim(strip_tags($news->getElement('news_first_paragraph')));
        } else {
            $fullShortIntroduction = trim($newsIntroduction->getData());
        }
        return StringTools::limitString($fullShortIntroduction, $limit);
    }

    public static function getCurrentNews(int $offset = -1, int $limit = -1, array $excludeIds = [])
    {
        $config = [
            'unpublished'   => false,
            'orderKey' => ['news_published_date'],
            'order' => 'desc'
        ];
        if ($offset >= 0) {
            $config['offset'] = $offset;
        }
        if ($limit > 0) {
            $config['limit'] = $limit;
        }

        if (!empty($excludeIds)) {
            if (1 === count($excludeIds)) {
                $config['condition'] = sprintf("documents.id != %d", $excludeIds[0]);
            } else {
                $config['condition'] = sprintf("documents.id NOT IN (%s)", join(',', $excludeIds));
            }
        }
        $list = NewsListing::getList($config);
        return $list;
    }

    /**
     * Set Offset < 0 or limit <= 0 to ignore offset and limit setting
     *
     * @param PageSnippet $news
     * @param int $offset
     * @param int $limit
     * @param array $excludeIds
     * @return NewsListing|array
     * @throws \Exception
     */
    public static function getRelatedNews($news, int $offset = -1, int $limit = -1, array $excludeIds = [])
    {
        if (!self::isNewsPage($news)) {
            $exception = new \Exception("Can not identify the news page");
            ApplicationLogger::getInstance()->logException(__METHOD__, $exception, 'error', $news);
            return [];
        }

        $tags = self::getTags($news);
        if (empty($tags)) {
            return [];
        }
        $config = [
            'unpublished'   => false,
            'orderKey' => ['news_published_date'],
            'order' => 'desc'
        ];

        if ($offset >= 0) {
            $config['offset'] = $offset;
        }
        if ($limit > 0) {
            $config['limit'] = $limit;
        }

        array_push($excludeIds, $news->getId());

        if (1 === count($excludeIds)) {
            $condition = sprintf('documents.id != %d', $news->getId());
        } else {
            $condition = sprintf('documents.id NOT IN (%s)', join(',', $excludeIds));
        }
        if (1 === count($tags)) {
            $condition .= sprintf(' AND tagid = %d', $tags[0]->getId());
        } else {
            $tagIds = [];
            foreach ($tags as $tag) {
                $tagIds[] = $tag->getId();
            }
            $condition .= sprintf(' AND tagid in (%s) ', join(',', $tagIds));
        }
        $config['condition'] = $condition;
        return NewsListing::getList($config);
    }

    /**
     * @param PageSnippet $news
     * @return \Pimcore\Model\Element\Tag[]
     */
    public static function getTags($news)
    {
        return Tag::getTagsForElement('document', $news->getId());
    }

    /**
     * @param $page
     * @return bool
     */
    public static function isNewsPage($page)
    {
        return ($page instanceof Page)
            && '@AppBundle\Controller\NewsController' === $page->getController()
            && 'detail' === $page->getAction();
    }

    /**
     * @param Document $news
     * @return string
     */
    public static function getAuthorName($news)
    {
        if ($news->getUserOwner()) {
            /** @var User $user */
            $user = User::getById($news->getUserOwner());
            if ($user) {
                return $user->getFirstname() . ' ' . $user->getLastname();
            }
        }
        return '';
    }
}
