<?php

namespace App\Migrations;

use AppBundle\Tool\FolderConstant;
use Doctrine\DBAL\Schema\Schema;
use Pimcore\Migrations\Migration\AbstractPimcoreMigration;
use Pimcore\Model\Document\Page;
use Pimcore\Model\Document\Tag\Input;
use Pimcore\Model\Document\Tag\Textarea;
use Pimcore\Model\Document\Tag\Wysiwyg;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180904144808 extends AbstractPimcoreMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $pageFullPath = FolderConstant::DOCUMENT_ROOT_FOLDER . FolderConstant::DEFAULT_LANGUAGE_FOLDER . '/proclub';
        $this->writeMessage(sprintf('Create page %s', $pageFullPath));
        /** @var Page $page */
        $page = Page::getByPath($pageFullPath);

        $page->getElements();
        $page->getProperties();

        $proclub_standings_description = new Textarea();
        $proclub_standings_description->setName("standings_description");
        $proclub_standings_description->setDataFromResource("Aktuelles aus dem Ligabetrieb");

        $page->setElement("standings_description", $proclub_standings_description);

        $proclub_about_title = new Wysiwyg();
        $proclub_about_title->setName("about_title");
        $proclub_about_title->setDataFromResource("Über den Pro Club");

        $page->setElement("about_title", $proclub_about_title);

        $proclub_player_title = new Wysiwyg();
        $proclub_player_title->setName("topplayer_title");
        $proclub_player_title->setDataFromResource("Top-Spieler");

        $page->setElement("topplayer_title", $proclub_player_title);

        $proclub_news_title = new Wysiwyg();
        $proclub_news_title->setName("news_title");
        $proclub_news_title->setDataFromResource("News");

        $page->setElement("news_title", $proclub_news_title);

        $proclub_standings_title = new Wysiwyg();
        $proclub_standings_title->setName("standings_title");
        $proclub_standings_title->setDataFromResource("Standings");

        $page->setElement("standings_title", $proclub_standings_title);

        $proclub_about_description = new Textarea();
        $proclub_about_description->setName("about_description");
        $proclub_about_description->setDataFromResource("Mitmachen. Zuschauen. Erleben.");

        $page->setElement("about_description", $proclub_about_description);

        $proclub_joinsub_description = new Textarea();
        $proclub_joinsub_description->setName("proclub_join_sub_header");
        $proclub_joinsub_description->setDataFromResource("Zeigt was ihr drauf habt!");

        $page->setElement("proclub_join_sub_header", $proclub_joinsub_description);

        $proclub_joinhead_title = new Wysiwyg();
        $proclub_joinhead_title->setName("proclub_join_header");
        $proclub_joinhead_title->setDataFromResource("Jetzt Mitmachen");

        $page->setElement("proclub_join_header", $proclub_joinhead_title);

        $page->save();

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
