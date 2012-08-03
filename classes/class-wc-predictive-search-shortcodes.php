<?php
/**
 * WC Predictive Search Hook Filter
 *
 * Hook anf Filter into woocommerce plugin
 *
 * Table Of Contents
 *
 * parse_shortcode_search_widget()
 * add_search_widget_icon()
 * add_search_widget_mce_popup()
 * parse_shortcode_search_result()
 * display_search()
 * get_result_search_page()
 */
class WC_Predictive_Search_Shortcodes {
	public static function parse_shortcode_search_widget($attributes) {
		extract(shortcode_atts(array(
			 'items' => 6,
			 'character_max' => 100,
			 'style' => '',
			 'wrap'	=> 'false'
        ), $attributes));
		
		$widget_id = rand(100, 10000);
		
		$wrap_div = '';
		if ($wrap == 'true') $wrap_div = '<div style="clear:both;"></div>';
		
		return WC_Predictive_Search_Widgets::woops_results_search_form($widget_id, $items, $character_max, $style, 1).$wrap_div;
	}
	
	function add_search_widget_icon($context){
		$image_btn = WOOPS_IMAGES_URL . "/ps_icon.png";
		$out = '<a href="#TB_inline?width=670&height=650&modal=false&inlineId=woo_search_widget_shortcode" class="thickbox" title="'.__('Insert WooCommerce Predictive Search Shortcode', 'woops').'"><img class="search_widget_shortcode_icon" src="'.$image_btn.'" alt="'.__('Insert WooCommerce Predictive Search Shortcode', 'woops').'" /></a>';
		return $context . $out;
	}
	
	//Action target that displays the popup to insert a form to a post/page
	function add_search_widget_mce_popup(){
		?>
		<script type="text/javascript">
			function woo_search_widget_add_shortcode(){
				var woo_search_number_items = jQuery("#woo_search_number_items").val();
				var woo_search_text_lenght = jQuery("#woo_search_text_lenght").val();
				var woo_search_align = jQuery("#woo_search_align").val();
				var woo_search_width = jQuery("#woo_search_width").val();
				var woo_search_padding_top = jQuery("#woo_search_padding_top").val();
				var woo_search_padding_bottom = jQuery("#woo_search_padding_bottom").val();
				var woo_search_padding_left = jQuery("#woo_search_padding_left").val();
				var woo_search_padding_right = jQuery("#woo_search_padding_right").val();
				var woo_search_style = '';
				var wrap = '';
				if (woo_search_align == 'center') woo_search_style += 'float:none;margin:auto;display:table;';
				else if (woo_search_align == 'left-wrap') woo_search_style += 'float:left;';
				else if (woo_search_align == 'right-wrap') woo_search_style += 'float:right;';
				else woo_search_style += 'float:'+woo_search_align+';';
				
				if(woo_search_align == 'left-wrap' || woo_search_align == 'right-wrap') wrap = 'wrap="true"';
				
				if (parseInt(woo_search_width) > 0) woo_search_style += 'width:'+parseInt(woo_search_width)+'px;';
				if (parseInt(woo_search_padding_top) >= 0) woo_search_style += 'padding-top:'+parseInt(woo_search_padding_top)+'px;';
				if (parseInt(woo_search_padding_bottom) >= 0) woo_search_style += 'padding-bottom:'+parseInt(woo_search_padding_bottom)+'px;';
				if (parseInt(woo_search_padding_left) >= 0) woo_search_style += 'padding-left:'+parseInt(woo_search_padding_left)+'px;';
				if (parseInt(woo_search_padding_right) >= 0) woo_search_style += 'padding-right:'+parseInt(woo_search_padding_right)+'px;';
				var win = window.dialogArguments || opener || parent || top;
				win.send_to_editor('[woocommerce_search_widget items="' + woo_search_number_items +'" character_max="'+woo_search_text_lenght+'" style="'+woo_search_style+'" '+wrap+ ']');
			}
			
			
		</script>
		<style type="text/css">
		#TB_ajaxContent{width:auto !important;}
		.field_content {
			padding:0 0 0 40px;
		}
		.field_content label{
			width:150px;
			float:left;
			text-align:left;
		}
		#woo_predictive_upgrade_area { border:2px solid #FF0;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; padding:0; position:relative}
	  	#woo_predictive_upgrade_area h3{ margin-left:10px;}
	   	#woo_predictive_extensions { background: url("<?php echo WOOPS_IMAGES_URL; ?>/logo_a3blue.png") no-repeat scroll 4px 6px #FFFBCC; -webkit-border-radius:4px;-moz-border-radius:4px;-o-border-radius:4px; border-radius: 4px 4px 4px 4px; color: #555555; float: right; margin: 0px; padding: 4px 8px 4px 38px; position: absolute; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); width: 260px; right:10px; top:140px; border:1px solid #E6DB55}
		</style>
		<div id="woo_search_widget_shortcode" style="display:none;">
		  <div class="">
			<h3><?php _e('Customize the Predictive Search Shortcode', 'woops'); ?></h3>
			<div style="clear:both"></div>
            <div id="woo_predictive_upgrade_area"><?php echo WC_Predictive_Search_Settings::predictive_extension_shortcode(); ?>
			<div class="field_content">
            	<p><label for="woo_search_number_items"><?php _e('Results', 'woops'); ?>:</label> <input disabled="disabled" style="width:100px;" size="10" id="woo_search_number_items" name="woo_search_number_items" type="text" value="6" /> <span class="description"><?php _e('Number of results to show in dropdown', 'woops'); ?></span></p>
            	<p><label for="woo_search_text_lenght"><?php _e('Characters', 'woops'); ?>:</label> <input disabled="disabled" style="width:100px;" size="10" id="woo_search_text_lenght" name="woo_search_text_lenght" type="text" value="100" /> <span class="description"><?php _e('Number of product description characters', 'woops'); ?></span></p>
                <p><label for="woo_search_align"><?php _e('Alignment', 'woops'); ?>:</label> <select disabled="disabled" style="width:100px" id="woo_search_align" name="woo_search_align"><option value="none" selected="selected"><?php _e('None', 'woops'); ?></option><option value="left-wrap"><?php _e('Left - wrap', 'woops'); ?></option><option value="left"><?php _e('Left - no wrap', 'woops'); ?></option><option value="center"><?php _e('Center', 'woops'); ?></option><option value="right-wrap"><?php _e('Right - wrap', 'woops'); ?></option><option value="right"><?php _e('Right - no wrap', 'woops'); ?></option></select> <span class="description"><?php _e('Horizontal aliginment of search box', 'woops'); ?></span></p>
                <p><label for="woo_search_width"><?php _e('Search box width', 'woops'); ?>:</label> <input disabled="disabled" style="width:100px;" size="10" id="woo_search_width" name="woo_search_width" type="text" value="200" /> px</p>
                <p><label for="woo_search_padding_top"><?php _e('Padding - Above', 'woops'); ?>:</label> <input disabled="disabled" style="width:100px;" size="10" id="woo_search_padding_top" name="woo_search_padding_top" type="text" value="10" /> px</p>
                <p><label for="woo_search_padding_bottom"><?php _e('Padding - Below', 'woops'); ?>:</label> <input disabled="disabled" style="width:100px;" size="10" id="woo_search_padding_bottom" name="woo_search_padding_bottom" type="text" value="10" /> px</p>
                <p><label for="woo_search_padding_left"><?php _e('Padding - Left', 'woops'); ?>:</label> <input disabled="disabled" style="width:100px;" size="10" id="woo_search_padding_left" name="woo_search_padding_left" type="text" value="0" /> px</p>
                <p><label for="woo_search_padding_right"><?php _e('Padding - Right', 'woops'); ?>:</label> <input disabled="disabled" style="width:100px;" size="10" id="woo_search_padding_right" name="woo_search_padding_right" type="text" value="0" /> px</p>
			</div>
            <p>&nbsp;&nbsp;<input disabled="disabled" type="button" class="button-primary" value="<?php _e('Insert Shortcode', 'woops'); ?>" onclick="woo_search_widget_add_shortcode();"/>&nbsp;&nbsp;&nbsp;
            <a class="button" style="" href="#" onclick="tb_remove(); return false;"><?php _e('Cancel', 'woops'); ?></a>
			</p>
           	</div>
		  </div>
		</div>
<?php
	}
	
	public static function parse_shortcode_search_result($attributes) {
    	return WC_Predictive_Search_Shortcodes::display_search();	
    }
	
	function get_product_price($product_id, $show_price=true) {
		$product_price_output = '';
		if ($show_price) {
			$current_product = new WC_Product($product_id);
			if ($current_product->is_type('grouped')) {
				$product_price_output = '<div class="rs_rs_price">'.__('Priced', 'woops').' '. $current_product->get_price_html(). '</div>';
			} elseif ($current_product->is_type('variable')) {
				$product_price_output = '<div class="rs_rs_price">'.__('Priced', 'woops').' '. $current_product->get_price_html(). '</div>';
			} else {
				$product_price_output = '<div class="rs_rs_price">'.__('Price', 'woops').': '. $current_product->get_price_html(). '</div>';
			}
		}
		
		return $product_price_output;
	}
	
	function get_product_categories($product_id, $show_categories=true) {
		$product_cats_output = '';
		if ($show_categories) {
			
			$product_cats = get_the_terms( $product_id, 'product_cat' );
						
			if ( $product_cats && ! is_wp_error( $product_cats ) ) {
				$product_cat_links = array();
				foreach ( $product_cats as $product_cat ) {
					$product_cat_links[] = '<a href="' .get_term_link($product_cat->slug, 'product_cat') .'">'.$product_cat->name.'</a>';
				}
				if (count($product_cat_links) > 0)
					$product_cats_output = '<div class="rs_rs_cat posted_in">'.__('Category', 'woops').': '.join( ", ", $product_cat_links ).'</div>';
			}
		}
		
		return $product_cats_output;
	}
	
	function get_product_tags($product_id, $show_tags=true) {
		$product_tags_output = '';
		if ($show_tags) {
			$product_tags = get_the_terms( $product_id, 'product_tag' );
						
			if ( $product_tags && ! is_wp_error( $product_tags ) ) {
				$product_tag_links = array();
				foreach ( $product_tags as $product_tag ) {
					$product_tag_links[] = '<a href="' .get_term_link($product_tag->slug, 'product_tag') .'">'.$product_tag->name.'</a>';
				}
				if (count($product_tag_links) > 0)
					$product_tags_output = '<div class="rs_rs_tag tagged_as">'.__('Tags', 'woops').': '.join( ", ", $product_tag_links ).'</div>';
			}
		}
		
		return $product_tags_output;
	}
	
	function display_search() {
		$p = 0;
		$row = 10;
		$search_keyword = '';
		$cat_slug = '';
		$tag_slug = '';
		$extra_parameter = '';
		$show_price = false;
		$show_categories = false;
		$show_tags = false;
		if (isset($_REQUEST['rs']) && trim($_REQUEST['rs']) != '') $search_keyword = $_REQUEST['rs'];
		
		$start = $p * $row;
		$end_row = $row;
				
		if ($search_keyword != '') {
			$args = array( 's' => $search_keyword, 'numberposts' => $row+1, 'offset'=> $start, 'orderby' => 'title', 'order' => 'ASC', 'post_type' => 'product', 'post_status' => 'publish');
			if ($cat_slug != '') {
				$args['tax_query'] = array( array('taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $cat_slug) );
				$extra_parameter .= '&scat='.$cat_slug;
			} elseif($tag_slug != '') {
				$args['tax_query'] = array( array('taxonomy' => 'product_tag', 'field' => 'slug', 'terms' => $tag_slug) );
				$extra_parameter .= '&stag='.$tag_slug;
			}
			
			$total_args = $args;
			$total_args['numberposts'] = -1;
			$total_args['offset'] = 0;
			
			//$search_all_products = get_posts($total_args);
									
			$search_products = get_posts($args);
						
			$html = '<p class="rs_result_heading">'.__('Showing all results for your search', 'woops').' | '.$search_keyword.'</p>';
			if ( $search_products && count($search_products) > 0 ){
					
				$html .= '<style type="text/css">
				.rs_result_heading{margin:15px 0;}
				.ajax-wait{display: none; position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; background:url("'.WOOPS_IMAGES_URL.'/ajax-loader.gif") no-repeat center center #EDEFF4; opacity: 1;text-align:center;}
				.ajax-wait img{margin-top:14px;}
				.p_data,.r_data,.q_data{display:none;}
				.rs_date{color:#777;font-size:small;}
				.rs_result_row{width:100%;float:left;margin:0px 0 10px;padding :0px 0 10px; 6px;border-bottom:1px solid #c2c2c2;}
				.rs_result_row:hover{opacity:1;}
				.rs_rs_avatar{width:64px;height:64px;margin-right:10px;overflow: hidden;}
				.rs_rs_avatar img{width:100%;height:auto; padding:0 !important; margin:0 !important; border: none !important;}
				.rs_rs_avatar{width:64px;height:64px;float:left;}
				.rs_rs_name{margin-left:0px;}
				.rs_content{margin-left:74px;}
				.rs_more_result{width:89.5%;float:left;padding:10px 5%;text-align:center;margin:10px 0;background: #EDEFF4;border: 1px solid #D8DFEA;position:relative;}
				.rs_rs_price .oldprice{text-decoration:line-through; font-size:80%;}
				</style>';
				$html .= '<div class="rs_ajax_search_content">';
				foreach ( $search_products as $product ) {
					$link_detail = get_permalink($product->ID);
					
					$avatar = WC_Predictive_Search::woops_get_product_thumbnail($product->ID,'shop_catalog',64,64);
					
					$product_price_output = WC_Predictive_Search_Shortcodes::get_product_price($product->ID, $show_price);
						
					$product_cats_output = WC_Predictive_Search_Shortcodes::get_product_categories($product->ID, $show_categories);
					
					$product_tags_output = WC_Predictive_Search_Shortcodes::get_product_tags($product->ID, $show_tags);
					
					$html .= '<div class="rs_result_row"><span class="rs_rs_avatar">'.$avatar.'</span><div class="rs_content"><a href="'.$link_detail.'"><span class="rs_rs_name">'.stripslashes( $product->post_title).'</span></a>'.$product_price_output.'<div class="rs_rs_description">'.WC_Predictive_Search::woops_limit_words($product->post_content,get_option('woocommerce_search_text_lenght'),'...').'</div>'.$product_cats_output.$product_tags_output.'</div></div>';
					
					$html .= '<div style="clear:both"></div>';
					$end_row--;
					if ($end_row < 1) break;
				}
				$html .= '</div>';
				if ( count($search_products) > $row ) {
					$woops_get_result_search_page = wp_create_nonce("woops-get-result-search-page");
					
					$html .= '<div id="search_more_rs"></div><div style="clear:both"></div><div class="rs_more_result"><span class="p_data">'.($p + 1).'</span><a class="see_more" href="#">'.__('See more results', 'woops').' <span>↓</span></a>
					<div class="ajax-wait">&nbsp;</div></div>';
					$html .= "<script>jQuery(document).ready(function() {
						
						jQuery('.see_more').live('click',function(){
							var wait = jQuery('.rs_more_result .ajax-wait');
							wait.css('display','block');
							var p_data_obj = jQuery(this).siblings('.p_data');
							var p_data = jQuery(this).siblings('.p_data').html();
							var urls = '&p='+p_data+'&row=".$row."&q=".$search_keyword.$extra_parameter."&action=woops_get_result_search_page&security=".$woops_get_result_search_page."';
							jQuery.post('".admin_url('admin-ajax.php')."', urls, function(theResponse){
								if(theResponse != ''){
									var num = parseInt(p_data)+1;
									p_data_obj.html(num);
									jQuery('#search_more_rs').append(theResponse);
								}else{
									jQuery('.rs_more_result').html('').hide();
								}
								wait.css('display','none');
							});
							return false;
						});});</script>";
				}
			} else {
				$html .= '<p style="text-align:center">'.__('No result', 'woops').'</p>';
			} 
			
			return $html;
		}
	}
	
	function get_result_search_page() {
		check_ajax_referer( 'woops-get-result-search-page', 'security' );
		$p = 1;
		$row = 10;
		$search_keyword = '';
		$cat_slug = '';
		$tag_slug = '';
		$extra_parameter = '';
		$show_price = false;
		$show_categories = false;
		$show_tags = false;
		if (isset($_REQUEST['p']) && $_REQUEST['p'] > 0) $p = $_REQUEST['p'];
		if (isset($_REQUEST['row']) && $_REQUEST['row'] > 0) $row = $_REQUEST['row'];
		if (isset($_REQUEST['q']) && trim($_REQUEST['q']) != '') $search_keyword = $_REQUEST['q'];
		
		$start = $p * $row;
		$end = $start + $row;
		$end_row = $row;
		
		if ($search_keyword != '') {
			$args = array( 's' => $search_keyword, 'numberposts' => $row+1, 'offset'=> $start, 'orderby' => 'title', 'order' => 'ASC', 'post_type' => 'product', 'post_status' => 'publish');
			if ($cat_slug != '') {
				$args['tax_query'] = array( array('taxonomy' => 'product_cat', 'field' => 'slug', 'terms' => $cat_slug) );
				$extra_parameter .= '&scat='.$cat_slug;
			} elseif($tag_slug != '') {
				$args['tax_query'] = array( array('taxonomy' => 'product_tag', 'field' => 'slug', 'terms' => $tag_slug) );
				$extra_parameter .= '&stag='.$tag_slug;
			}
			
			$total_args = $args;
			$total_args['numberposts'] = -1;
			$total_args['offset'] = 0;
			
			//$search_all_products = get_posts($total_args);
									
			$search_products = get_posts($args);
						
			$html = '';
			if ( $search_products && count($search_products) > 0 ){
				$html .= '<div class="rs_ajax_search_content">';
				foreach ( $search_products as $product ) {
					$link_detail = get_permalink($product->ID);
					
					$avatar = WC_Predictive_Search::woops_get_product_thumbnail($product->ID,'shop_catalog',64,64);
					
					$product_price_output = WC_Predictive_Search_Shortcodes::get_product_price($product->ID, $show_price);
						
					$product_cats_output = WC_Predictive_Search_Shortcodes::get_product_categories($product->ID, $show_categories);
					
					$product_tags_output = WC_Predictive_Search_Shortcodes::get_product_tags($product->ID, $show_tags);
										
					$html .= '<div class="rs_result_row"><span class="rs_rs_avatar">'.$avatar.'</span><div class="rs_content"><a href="'.$link_detail.'"><span class="rs_rs_name">'.stripslashes( $product->post_title).'</span></a>'.$product_price_output.'<div class="rs_rs_description">'.WC_Predictive_Search::woops_limit_words($product->post_content,get_option('woocommerce_search_text_lenght'),'...').'</div>'.$product_cats_output.$product_tags_output.'</div></div>';
					$html .= '<div style="clear:both"></div>';
					$end_row--;
					if ($end_row < 1) break;
				}
				
				if ( count($search_products) <= $row ) {
					
					$html .= '<style>.rs_more_result{display:none;}</style>';
				}
				
				$html .= '</div>';
			}
			echo $html;
		}
		die();
	}
}
?>