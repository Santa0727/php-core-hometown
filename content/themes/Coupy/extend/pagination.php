<?php

function couponscms_theme_pagination( $pagination, $links = 2 ) {

    if( !isset( $pagination['pages'] ) || (int) $pagination['pages'] <= 1 ) {
        return false;
    }

    $markup = '';

    $override = do_action( 'override_navigation', $pagination );

    if( !$override ) {

        $start      = ( ( $pagination['page'] - $links ) > 0 ) ? $pagination['page'] - $links : 1;
        $end        = ( ( $pagination['page'] + $links ) < $pagination['pages'] ) ? $pagination['page'] + $links : $pagination['pages'];

        $markup     .= '<div class="row">
        <div class="col-md-12 text-center">
        <ul class="pagination">';

        $markup     .= '<li' . ( ( $pagination['page'] == 1 ) ? ' class="disabled"' : '' ) . '><a href="' . get_update( array( 'page' => ( $pagination['page'] == 1 ? 1 : ( $pagination['page'] - 1 ) ) ), get_remove( array( 'cid', 'pid' ) ) ) . '">' . t( 'theme_pagination_prev', '&laquo; Prev ' ) . '</a></li>';

        if ( $start > 1 ) {
            $markup   .= '<li><a href="' . get_update( array( 'page' => 1 ), get_remove( array( 'cid', 'pid' ) ) ) . '">1</a></li>';
            if( ( $pagination['page'] - ($links+1 ) ) > 1 ) $markup   .= '<li class="disabled"><span>...</span></li>';
        }

        for ( $i = $start ; $i <= $end; $i++ ) {
            $markup .= '<li' . ( $pagination['page'] == $i ? ' class="active button-disabled"' : '' ) . '><a href="' . get_update( array( 'page' => $i ), get_remove( array( 'cid', 'pid' ) ) ) . '">' . $i . '</a></li>';
        }

        if ( $end < $pagination['pages'] ) {
            if( ( $pagination['page'] + ($links+1) ) < $pagination['pages'] ) $markup .= '<li class="disabled"><span>...</span></li>';
            $markup .= '<li><a href="' . get_update( array( 'page' => $pagination['pages'] ), get_remove( array( 'cid', 'pid' ) ) ) . '">' . $pagination['pages'] . '</a></li>';
        }

        $markup     .= '<li' . ( ( $pagination['page'] == $pagination['pages'] ) ? ' class="disabled"' : '' ) . '><a href="' . get_update( array( 'page' => ( $pagination['page'] == $pagination['pages'] ? $pagination['pages'] : ( $pagination['page'] + 1 ) ) ), get_remove( array( 'cid', 'pid' ) ) ) . '">' . t( 'theme_pagination_next', 'Next &raquo;' ) . '</a></li>';

        $markup     .= '</ul>
        </div></div>';

    } else $markup .= $override;

    return $markup;

}