<?php

class UMC_PageService
{


    function getAllPageUrl()
    {


        $posts_query = new WP_Query(array(
            'post_type' => "any",
            'post_status' => array('publish', 'pending', 'draft', 'future', 'private'),
            'posts_per_page' => -1,
            //TODO: add size and page
            //'offset' => $offset,
            'orderby' => 'title',
            'order' => 'ASC'
        ));

        $links = [];
        while ($posts_query->have_posts()):
            $posts_query->the_post();
            $links[] = get_permalink();
        endwhile;

        return $links;
    }


}
