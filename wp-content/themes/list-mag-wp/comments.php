<?php if ( post_password_required() ) : ?>
    <p class="nopassword"><?php esc_html_e('This post is password protected. Enter the password to view any comments.', 'list-mag-wp'); ?></p>
<?php return; endif; ?>

<?php if ( have_comments() ) : ?>
    <?php // comments_number('No Comments', '1 Comment', '% Comments' );?>
 
            <ul class="comment">
                <?php wp_list_comments( array( 'callback' => 'list_mag_wp_comment' ) ); ?>
            </ul>
            <div class="clear"></div>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
        <div class="pagination">
            <?php previous_comments_link('&lsaquo; ' . esc_html__('Older Comments', 'list-mag-wp') . ''); ?>
            <?php next_comments_link('' . esc_html__('Newer Comments', 'list-mag-wp') . ' &rsaquo;'); ?>
            <div class="clear"></div>
        </div>
<?php endif; // check for comment navigation ?>


<?php else : // or, if we don't have comments:
    if ( ! comments_open() ) : ?>
    <p class="nocomments"><?php esc_html_e('Comments are closed.', 'list-mag-wp'); ?></p>
<?php endif; // end ! comments_open() ?>
<?php endif; // end have_comments() ?>

 

<?php 

$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );

$comment_args = array( 'fields' => apply_filters( 'comment_form_default_fields', array(

//Author
'author' => '
            <div class="one_half_c">
             <label for="author">' . esc_html__('Name:', 'list-mag-wp') . '<span>*</span></label> 
             <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" ' . $aria_req . ' />
            </div>',

//Email
'email' => '
            <div class="one_half_last_c">
             <label for="email">' . esc_html__('Email:', 'list-mag-wp') . '<span>*</span></label> 
             <input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" ' . $aria_req . ' />
            </div>',)),

//Comment
'comment_field' =>'
            <div class="one_full_c">
               <label for="comment">' . esc_html__('Comment:', 'list-mag-wp') . '<span>*</span></label>
               <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>     
            </div>',
 

'comment_notes_after' => '',
'title_reply' => '' . esc_html__('Leave a Comment', 'list-mag-wp') . '', 
'title_reply_to' => '' . esc_html__('Leave a Reply to %s', 'list-mag-wp') . '', 
'label_submit' => '' . esc_html__('Submit Comment', 'list-mag-wp') . '',
'id_submit' => 'sendemail',
); ?>
<?php comment_form($comment_args); ?>