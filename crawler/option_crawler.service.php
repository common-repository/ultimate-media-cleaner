<?php


class UMC_OptionCrawlerService
{

    public $umc_crawler_option = 'umc_option_crawler';


    public function getOptionsCrawler()
    {
        return get_option($this->umc_crawler_option);
    }

    public function addOrUpdateOptionCrawler($optionCrawler)
    {
        if (!get_option($this->umc_crawler_option, false)) {
            add_option($this->umc_crawler_option, $optionCrawler);
        } else {
            update_option($this->umc_crawler_option, $optionCrawler);
        }

    }

    public function cleanOptionCrawler()
    {
        delete_option($this->umc_crawler_option);
    }

}
