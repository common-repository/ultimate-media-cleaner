<?php

class UMC_TranslationRest
{


    function addRestEndpoints()
    {
        add_action('rest_api_init', array($this, 'restEndpoint'));
    }

    function restEndpoint()
    {

        register_rest_route(UMC_ENDPOINT, '/translation', array(
                'methods' => 'GET',
                'callback' => [$this, 'treatRestCall'],
                'permission_callback' => function () {
                    return current_user_can('administrator');
                }
            )
        );
    }

    function treatRestCall()
    {
        $translation = [];

        $this->addCommon($translation);
        $this->addTunnelWarning($translation);
        $this->addMain($translation);
        $this->addAttachmentDb($translation);
        $this->addAttachmentServer($translation);
        $this->addAttachment($translation);
        $this->addOptions($translation);
        $this->addFolders($translation);
        $this->addAttachmentDelete($translation);
        $this->addCrawler($translation);

        $response = new WP_REST_Response($translation, 200);
        $response->set_headers(wp_get_nocache_headers());
        return $response;
    }

    private function addTunnelWarning(&$translation)
    {
        $translation['tunnel.retry'] = __('Retry', 'ultimate-media-cleaner');
        $translation['tunnel.answers.take_test'] = __('Take the test before', 'ultimate-media-cleaner');

        $translation['tunnel.begin.title'] = __('Welcome to ultimate media cleaner', 'ultimate-media-cleaner');
        $translation['tunnel.begin.text'] = __('Before using this plugin we are going to make a little test, you can only use this plugin if you know how dangerous and how to use it', 'ultimate-media-cleaner');
        $translation['tunnel.begin.text2'] = __('I know that you want to use it and you want it to work like it should, but WP is a very complex software, WP give you every kind of possibility, you can us it like a blog, e-commerce site, normal website, etc', 'ultimate-media-cleaner');
        $translation['tunnel.begin.text3'] = __('This plugin delete files in your server and information in your database, and they are not reversible, the only way to go back is with one backup system, your backup system have to take in count your upload folder and your database', 'ultimate-media-cleaner');
        $translation['tunnel.begin.text4'] = __('This plugin try to take that in account, but is impossible to make it 100% accurate, you have to take slowly, test this plugin with not important stuff, and if you see that is working like it should, you can go further, but keeping in mind that you need to verify sometimes that this plugin and your action can by messing with your site', 'ultimate-media-cleaner');
        $translation['tunnel.begin.text5'] = __('This plugin do nothing without your actions, you are the person who click the delete button, is up to you to verify that this plugin is working with your WP configuration', 'ultimate-media-cleaner');
        $translation['tunnel.begin.text6'] = __('I verified this plugin with one WP vanilla configuration (normal)', 'ultimate-media-cleaner');

        $translation['tunnel.begin.next'] = __('I understand, i will take the test');


        $translation['tunnel.questions.title'] = __('Questions');
        $translation['tunnel.questions.next'] = __('View result');
        $translation['tunnel.questions.is_safe.title'] = __('Is safe to use ultimate media cleaner?');
        $translation['tunnel.questions.is_safe.help'] = __('This plugin help you to find unused files, but because wordpress have a very large and complex plugin system, is impossible to have 100% accurate results, this plugin going delete files and information from your database');
        $translation['tunnel.questions.is_safe.yes'] = __('Yes, i will go crazy and delete everything this plugin show like is not used');
        $translation['tunnel.questions.is_safe.no'] = __('It can be safe if i know what i\'m doing, i will be careful and make some test before using it');

        $translation['tunnel.questions.is_accurate.title'] = __('Is "not usage found" label 100% accurate?');
        $translation['tunnel.questions.is_accurate.help'] = __('Plugin and themes can add any kind of logic to your wordpress site and this plugin use a very generic/global logic search for used files, but is impossible to know how all your plugins/theme make use of files ', 'ultimate-media-cleaner');
        $translation['tunnel.questions.is_accurate.yes'] = __('Yes, "not usage found" are 100% accurate', 'ultimate-media-cleaner');
        $translation['tunnel.questions.is_accurate.no'] = __('Not really, can be from 0% to 100% because it depends of every plugin and themes installed in my site', 'ultimate-media-cleaner');

        $translation['tunnel.questions.is_dangerous.title'] = __('There is a risk to use Ultimate media cleaner?', 'ultimate-media-cleaner');
        $translation['tunnel.questions.is_dangerous.help'] = __('Some plugins and themes need the files to work like it should, most of them does not have the possibility to regenerate the files need', 'ultimate-media-cleaner');
        $translation['tunnel.questions.is_dangerous.yes'] = __('Everything going to be fine, IF i follow the instructions give by the plugin', 'ultimate-media-cleaner');
        $translation['tunnel.questions.is_dangerous.no'] = __('No and i really don\'t care, i will use this plugin without any knowledge', 'ultimate-media-cleaner');

        $translation['tunnel.questions.need_backup.title'] = __('Backups are needed before using this plugin?', 'ultimate-media-cleaner');
        $translation['tunnel.questions.need_backup.help'] = __('Your site is very important to you and keep in mind the << Murphy\'s First Law: Anything that can go wrong will go wrong >>. ', 'ultimate-media-cleaner');
        $translation['tunnel.questions.need_backup.yes'] = __('I know that is recommended it and will try make one backup everytime i want to use this plugin', 'ultimate-media-cleaner');
        $translation['tunnel.questions.need_backup.no'] = __('I trust this plugin, i don\'t need any backup', 'ultimate-media-cleaner');

        $translation['tunnel.questions.need_test.title'] = __('You need to test always this plugin?');
        $translation['tunnel.questions.need_test.help'] = __('Your site change all the time, you can install/remove plugins and themes all the time, so please test this plugin with not important part of your site, before going at extensive use, your site is important for for you! ', 'ultimate-media-cleaner');
        $translation['tunnel.questions.need_test.yes'] = __('Yes, i will make some test every time i use this plugin, even if my site does not change the plugins and themes', 'ultimate-media-cleaner');
        $translation['tunnel.questions.need_test.no'] = __('No, i\'m crazy and i will use it without any test' , 'ultimate-media-cleaner');

        $translation['tunnel.answers.title'] = __('Results');
        $translation['tunnel.answers.good'] = __('Congratulation, you seem to understand that you need to be careful using this plugins', 'ultimate-media-cleaner');
        $translation['tunnel.answers.bad'] = __('Sorry you can not use this plugin with you current answers, you need to learn more about this plugin, so please go and ask some questions and try again', 'ultimate-media-cleaner');

        $translation['tunnel.go'] = __('Click me to go to the main page', 'ultimate-media-cleaner');


    }

    private function addCommon(&$translation)
    {
        $translation['ASKING'] = __("Verifying usage ", 'ultimate-media-cleaner');
        $translation['USED'] = __("Used", 'ultimate-media-cleaner');
        $translation['NOT_USED'] = __("Not usage found", 'ultimate-media-cleaner');
        $translation['ERROR'] = __("Error in verification", 'ultimate-media-cleaner');
        $translation['IGNORED'] = __("Ignored", 'ultimate-media-cleaner');
        $translation['CHILDREN_USED'] = __("Some child is used", 'ultimate-media-cleaner');

        $translation['common.next'] = __("Next", 'ultimate-media-cleaner');
        $translation['common.back'] = __("Back", 'ultimate-media-cleaner');
        $translation['common.ok'] = __("Ok", 'ultimate-media-cleaner');
        $translation['common.cancel'] = __("Cancel", 'ultimate-media-cleaner');
        $translation['common.validate'] = __("Validate", 'ultimate-media-cleaner');
    }

    private function addMain(&$translation)
    {
        $translation['main.menu.attachments_db'] = __("Medias database", 'ultimate-media-cleaner');
        $translation['main.menu.attachments_server'] = __("Medias server", 'ultimate-media-cleaner');
        $translation['main.menu.attachments_delete'] = __("Attachment to delete", 'ultimate-media-cleaner');
        $translation['main.menu.folders'] = __("Folders", 'ultimate-media-cleaner');
        $translation['main.menu.options'] = __("Options", 'ultimate-media-cleaner');
        $translation['main.menu.crawler'] = __("Crawler", 'ultimate-media-cleaner');
    }

    private function addAttachment(&$translation) {

        $translation['attachment.nothing_found'] = __("Nothing found", 'ultimate-media-cleaner');
        $translation['attachment.verification_skipped'] = __("Skipped", 'ultimate-media-cleaner');
        $translation['attachment.status_found']  = __("Found", 'ultimate-media-cleaner');
        $translation['attachment.status_error']  = __("Error", 'ultimate-media-cleaner');

        $translation['attachment.attachment_type'] = __("Attachment type", 'ultimate-media-cleaner');
        $translation['attachment.image'] = __("Image", 'ultimate-media-cleaner');
        $translation['attachment.all'] = __("All", 'ultimate-media-cleaner');

        $translation['attachment.size'] = __("Size", 'ultimate-media-cleaner');
        $translation['attachment.url'] = __("Url", 'ultimate-media-cleaner');
        $translation['attachment.source'] = __("Source", 'ultimate-media-cleaner');
        $translation['attachment.directory'] = __("Directory", 'ultimate-media-cleaner');
        $translation['attachment.image_size_name'] = __("Image size name", 'ultimate-media-cleaner');
        $translation['attachment.dimension'] = __("Dimension", 'ultimate-media-cleaner');

        $translation['attachment.checkers_result'] = __("In checkers result", 'ultimate-media-cleaner');
        $translation['attachment.excerpt_all'] = __("In excerpt all", 'ultimate-media-cleaner');
        $translation['attachment.excerpt_parent'] = __("In excerpt parent", 'ultimate-media-cleaner');
        $translation['attachment.post_and_page_all'] = __("In post and page all", 'ultimate-media-cleaner');
        $translation['attachment.post_and_page_parent'] = __("In Post and page parent", 'ultimate-media-cleaner');
        $translation['attachment.post_meta'] = __("In post meta", 'ultimate-media-cleaner');
        $translation['attachment.verification_crawler'] = __("In crawler", 'ultimate-media-cleaner');

        $translation['attachment.add_delete_parent'] = __("Add to delete wish list", 'ultimate-media-cleaner');
        $translation['attachment.add_ignore_parent'] = __("Add to ignore list", 'ultimate-media-cleaner');
        $translation['attachment.ignored_child_for_parent'] = __("Child ignored", 'ultimate-media-cleaner');
        $translation['attachment.ignored_parent'] = __("Ignored", 'ultimate-media-cleaner');
        $translation['attachment.undo_ignored_parent'] = __("Undo ignored", 'ultimate-media-cleaner');
        $translation['attachment.child_in_delete_list_for_parent'] = __("no option available because some child is in the delete list", 'ultimate-media-cleaner');
        $translation['attachment.to_delete_parent'] = __("To delete", 'ultimate-media-cleaner');
        $translation['attachment.undo_to_delete_parent'] = __("Undo from wish to delete", 'ultimate-media-cleaner');
        $translation['attachment.child_different_used_for_parent'] = __("no option available because children status are different", 'ultimate-media-cleaner');

        $translation['attachment.add_delete_child'] = __("Add to delete wish child list", 'ultimate-media-cleaner');
        $translation['attachment.add_ignore_child'] = __("Add to ignore child list", 'ultimate-media-cleaner');
        $translation['attachment.ignored_child'] = __("Ignored", 'ultimate-media-cleaner');
        $translation['attachment.undo_child_ignored'] = __("Undo child ignored", 'ultimate-media-cleaner');
        $translation['attachment.to_delete_child'] = __("To delete", 'ultimate-media-cleaner');
        $translation['attachment.undo_to_delete_child'] = __("Undo to delete wish child", 'ultimate-media-cleaner');
        $translation['attachment.parent_to_delete'] = __("will be deleted with parent", 'ultimate-media-cleaner');

        $translation['attachment.without_db_reference'] = __("Without db reference", 'ultimate-media-cleaner');

    }


    private function addAttachmentDelete(&$translation)
    {
        $translation['attachment_delete.without_db_reference'] = __("Without db reference", 'ultimate-media-cleaner');

        $translation['attachment_delete.parents'] = __("Parents", 'ultimate-media-cleaner');
        $translation['attachment_delete.children'] = __("Children", 'ultimate-media-cleaner');
        $translation['attachment_delete.to_delete_parent'] = __("Delete parent", 'ultimate-media-cleaner');
        $translation['attachment_delete.undo_to_delete_parent'] = __("Undo to delete parent", 'ultimate-media-cleaner');

        $translation['attachment_delete.to_delete_child'] = __("To delete", 'ultimate-media-cleaner');
        $translation['attachment_delete.undo_to_delete_child'] = __("Undo to delete child", 'ultimate-media-cleaner');
    }


    private function addFolders(&$translation)
    {
        $translation['folders.work_in_progress'] = __("Work in progress, coming soon", 'ultimate-media-cleaner');
    }

    private function addOptions(&$translation)
    {

        $translation['options.scan_and_delete'] = __("Scan and buttons", 'ultimate-media-cleaner');

        $translation['options.show_children_button_title'] = __("Show buttons for children", 'ultimate-media-cleaner');
        $translation['options.show_children_button_children_body'] = __("This option is very hard to explain, if is active, you will have the option to delete children (normally images), but because wordpress implement something call \"Responsive images\", all children can be used, without any reference in the database, BUT there are one good news, if you delete one child, normally WP will not use the child in their reference, BUT other plugin/theme could maybe use it", 'ultimate-media-cleaner');
        $translation['options.show_children_button_children_help'] = __("This option can be useful when you need space in your hard drive server, use this option wisely, read about your installed themes and plugins, to see if they are using this functions. ", 'ultimate-media-cleaner');

        $translation['options.save_and_clean'] = __("Save and clean", 'ultimate-media-cleaner');

        $translation['options.save_in_database_title'] = __("Save the information in the databae", 'ultimate-media-cleaner');
        $translation['options.save_in_database_body'] = __("Activate this option for keep track of all ignored, to delete files in your database, and work any where you want", 'ultimate-media-cleaner');
        $translation['options.save_in_database_help'] = __("If this option is disabled, the information will be saved in you local browser, so it will lost if you change of browser, computer or session", 'ultimate-media-cleaner');

        $translation['options.undo_ignored_children_title'] = __("Undo all ignored children", 'ultimate-media-cleaner');
        $translation['options.undo_ignored_children_body'] = __("Use this button to undo all ignored children", 'ultimate-media-cleaner');
        $translation['options.undo_ignored_children_help'] = __("You can always go one by one and make the undo action", 'ultimate-media-cleaner');
        $translation['options.undo_ignored_children_action'] = __("Undo ignored children", 'ultimate-media-cleaner');

        $translation['options.undo_ignored_parent_title'] = __("Undo all ignored parent", 'ultimate-media-cleaner');
        $translation['options.undo_ignored_parent_body'] = __("Use this button to undo all ignored parent", 'ultimate-media-cleaner');
        $translation['options.undo_ignored_parent_help'] = __("You can always go one by one and make the undo action", 'ultimate-media-cleaner');
        $translation['options.undo_ignored_parent_action'] = __("Undo ignored parent", 'ultimate-media-cleaner');

        $translation['options.undo_to_delete_children_title'] = __("Undo all to delete children", 'ultimate-media-cleaner');
        $translation['options.undo_to_delete_children_body'] = __("Use this button to undo all to delete children", 'ultimate-media-cleaner');
        $translation['options.undo_to_delete_children_help'] = __("You can always go one by one and make the undo action", 'ultimate-media-cleaner');
        $translation['options.undo_to_delete_children_action'] = __("Undo delete children", 'ultimate-media-cleaner');

        $translation['options.undo_to_delete_parent_title'] = __("Undo all to delete parent", 'ultimate-media-cleaner');
        $translation['options.undo_to_delete_parent_body'] = __("Use this button to undo all to delete parent", 'ultimate-media-cleaner');
        $translation['options.undo_to_delete_parent_help'] = __("You can always go one by one and make the undo action", 'ultimate-media-cleaner');
        $translation['options.undo_to_delete_parent_action'] = __("Undo delete parents", 'ultimate-media-cleaner');

        $translation['options.pagination'] = __("Pagination", 'ultimate-media-cleaner');


        $translation['options.attachment_type'] = __("Attachment type", 'ultimate-media-cleaner');
        $translation['options.limit'] = __("Size of search", 'ultimate-media-cleaner');
        $translation['options.page'] = __("Page of search", 'ultimate-media-cleaner');

        $translation['options.only_pro'] = __("Only pro version", 'ultimate-media-cleaner');

        $translation['options.crawl_all_pages'] = __("Crawl all pages", 'ultimate-media-cleaner');
        $translation['options.crawl_all_pages_help'] = __("This will found out each post, page in your site, and one crawler will find all images and links in your site", 'ultimate-media-cleaner');
        $translation['options.crawl_all_pages_button'] = __("Crawl all pages", 'ultimate-media-cleaner');
        $translation['options.see_crawler_page'] = __("You can use the to crawler page", 'ultimate-media-cleaner');


    }

    private function addAttachmentDb(&$translation)
    {
        $translation['attachment_db.title'] = __("Medias in your database", 'ultimate-media-cleaner');
        $translation['attachment_db.body'] = __("All files show here are from you database, you can see if they are used and will help you to identify lost files, they are in your database but some reason they are not in your server", 'ultimate-media-cleaner');
    }

    private function addAttachmentServer(&$translation)
    {
        $translation['attachment_server.title'] = __("Medias in your server", 'ultimate-media-cleaner');
        $translation['attachment_server.body'] = __("All files show here are from you server, you can see if they are used and will help you to identify lost files, they are in your server but some reason they are not in your database", 'ultimate-media-cleaner');
        $translation['attachment_server.select_directories'] = __("Select the directory", 'ultimate-media-cleaner');
        $translation['attachment_server.nothing_found'] = __("This directory seem to be empty", 'ultimate-media-cleaner');

    }

    private function addCrawler(&$translation)
    {
        $translation['crawler.title'] = __("Crawler option", 'ultimate-media-cleaner');
        $translation['crawler.crawler_help'] = __("This can help you to see every images and link used in your site, this option is very useful to improve accuracy in the 'Not usage found' label", 'ultimate-media-cleaner');
        $translation['crawler.active'] = __("Active", 'ultimate-media-cleaner');
        $translation['crawler.uuid'] = __("UUID", 'ultimate-media-cleaner');
        $translation['crawler.licence'] = __("Licence", 'ultimate-media-cleaner');
        $translation['crawler.status'] = __("Status", 'ultimate-media-cleaner');


    }

}

//global $instance;
$instance = new UMC_TranslationRest();
$instance->addRestEndpoints();


