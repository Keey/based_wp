<?php get_header();
$catID = get_queried_object()->term_id;
$catN = get_queried_object()->name;
$curauth = $wp_query->get_queried_object();

//if(is_post_type_archive('projects')){
//    wp_redirect(site_url());
//}

if(is_date()){
    $queryname = 'Archive of '.date("F").', '.date('Y');
} elseif(is_category()) {
    $queryname = single_cat_title('', false);
} elseif(is_author()) {
    $queryname = 'Posts by ' . $curauth->nickname;
} else {
    $queryname = get_the_title(BLOG_ID);
} ?>
<?php if($queryname) : echo '<h1>'. $queryname. '</h1>'; endif; ?>
<section class="content row">
    <article>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="blogpost">
                <?php if ( has_post_thumbnail() ) { ?>
                    <div class="thumb">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    </div>
                <?php } ?>
                <div class="excerpt">
                    <a href="<?php the_permalink(); ?>" class="blogtitle"><?php the_title(); ?></a>
                    <div class="blogmeta">
                        <div class="author"><?php the_author(); ?></div>
                        <div class="ccount"><?php comments_number( 'No comments', 'One comment', '% comments' ); ?></div>
                        <time><?php the_date( 'F j'); ?><span>, <?php echo get_the_date('Y'); ?></span></time>
                    </div>
                  <?php echo wp_trim_words( get_the_content(), 40, '... <a  href="'. get_permalink() .'" class="rm">Learn More</a>'  ); ?>
                </div>
            </div>
        <?php endwhile;
        //wp_pagenavi();
        endif;?>
    </article>
    <aside>
        <?php dynamic_sidebar('Blog Sidebar'); ?>
    </aside>
</section>
<?php get_footer(); ?>

