<?php
/**
 * This template contains the content header part for an article on /friends/.
 *
 * @package Friends
 */

?><header class="entry-header card-header columns">
	<div class="avatar col-auto">
		<?php if ( Friends::CPT === get_post_type() ) : ?>
			<a href="<?php echo esc_attr( $friend_user->get_local_friends_page_url() ); ?>" class="author-avatar">
				<img src="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ) ) ); ?>" width="36" height="36" class="avatar" />
			</a>
		<?php else : ?>
			<a href="<?php echo esc_url( get_the_author_meta( 'url' ) ); ?>" class="author-avatar">
				<img src="<?php echo esc_url( $avatar ? $avatar : get_avatar_url( get_the_author_meta( 'ID' ) ) ); ?>" width="36" height="36" class="avatar" />
			</a>
		<?php endif; ?>
	</div>
	<div class="post-meta col-auto">
		<div class="author">
			<?php if ( Friends::CPT === get_post_type() ) : ?>
				<a href="<?php echo esc_attr( $friend_user->get_local_friends_page_url() ); ?>">
					<strong><?php the_author(); ?></strong>
				</a>
			<?php else : ?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<strong><?php the_author(); ?></strong>
				</a>
			<?php endif; ?>
		</div>
		<?php
		echo wp_kses(
			sprintf(
			// translators: %1$s is a date or relative time, %2$s is a site name or domain.
				__( '%1$s on %2$s', 'friends' ),
				'<a href="' . esc_attr( $friend_user->get_local_friends_page_url() . get_the_ID() . '/' ) . '" title="' . get_the_time( 'r' ) . '">' .
				/* translators: %s is a time span */ sprintf( __( '%s ago' ), human_time_diff( get_the_time( 'U' ), time() ) ) .
				'</a>',
				'<a href="' . esc_url( get_the_permalink() ) . '" rel="noopener noreferrer" target="_blank">' . esc_html( parse_url( get_the_permalink(), PHP_URL_HOST ) ) . '</a>'
			),
			array(
				'a' => array(
					'href'   => array(),
					'rel'    => array(),
					'target' => array(),
					'title'  => array(),
				),
			)
		);
		?>

	</div>
	<div class="overflow col-ml-auto">
		<a class="btn btn-link collapse-post" tabindex="0">
			<i class="dashicons dashicons-fullscreen-exit-alt"></i>
		</a>

		<div class="dropdown dropdown-right">
			<a class="btn btn-link dropdown-toggle" tabindex="0">
				<i class="dashicons dashicons-menu-alt2"></i>
			</a>
			<ul class="menu">
				<?php
				$edit_user_link = $friends->admin->admin_edit_user_link( false, get_the_author_meta( 'ID' ) );
				if ( $edit_user_link ) :
					?>
					<li class="menu-item"><a href="<?php echo esc_attr( $edit_user_link ); ?>"><?php _e( 'Edit friend', 'friends' ); ?></a></li>
				<?php endif; ?>
					<li class="menu-item dropdown">
						<select name="post-format" class="friends-change-post-format form-select select-sm" data-change-post-format-nonce="<?php echo esc_attr( wp_create_nonce( 'friends-change-post-format_' . get_the_ID() ) ); ?>" data-id="<?php echo esc_attr( get_the_ID() ); ?>" >
							<option disabled="disabled"><?php _e( 'Change post format', 'friends' ); ?></option>
							<?php foreach ( get_post_format_strings() as $format => $title ) : ?>
							<option value="<?php echo esc_attr( $format ); ?>"<?php selected( get_post_format(), $format ); ?>><?php echo esc_html( $title ); ?></option>
						<?php endforeach; ?>
						</select>
					</li>
				<?php if ( current_user_can( 'edit_post', $post->ID ) ) : ?>
					<li class="menu-item"><?php edit_post_link(); ?></li>
				<?php endif; ?>
				<?php if ( Friends::CPT === get_post_type() ) : ?>
					<li class="menu-item"><a href="<?php echo esc_url( self_admin_url( 'admin.php?page=edit-friend-rules&user=' . get_the_author_meta( 'ID' ) ) ); ?>" title="<?php esc_attr_e( 'Muffle posts like these', 'friends' ); ?>"class="friends-muffle-post">
						<?php _e( 'Muffle posts like these', 'friends' ); ?>
					</a></li>
					<li class="menu-item"><a href="#" title="<?php esc_attr_e( 'Trash this post', 'friends' ); ?>" data-trash-nonce="<?php echo esc_attr( wp_create_nonce( 'trash-post_' . get_the_ID() ) ); ?>" data-untrash-nonce="<?php echo esc_attr( wp_create_nonce( 'untrash-post_' . get_the_ID() ) ); ?>" data-id="<?php echo esc_attr( get_the_ID() ); ?>" class="friends-trash-post">
						<?php _e( 'Trash this post', 'friends' ); ?>
					</a></li>
				<?php endif; ?>

				</li>
			</ul>
		</div>

	</div>
</header>
