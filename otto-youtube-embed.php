<?php
/**
 * Plugin Name: Otto YouTube Embed
 * Plugin URI: http://andrelotto.tk/
 * Description: An plugin to embed YouTube videos responsively.
 * Version: 1.0
 * Author: André Luís Otto
 */

function youtube_embed_callback($atts=null, $content=null)
{
      extract($atts);
 
      return "<div class='youtube-container-parent'><div class='youtube-container-child'><div class='youtube-video' data-id='". $id ."'></div></div></div>";
}
 
add_shortcode("youtube", "youtube_embed_callback");


function register_youtube_embed_plugin_scripts()
{
      wp_register_script("youtube-embed-js", plugins_url("otto-youtube-embed/otto-youtube-embed.js"));
      wp_enqueue_script("youtube-embed-js");
}
 
add_action("wp_enqueue_scripts", "register_youtube_embed_plugin_scripts");


function register_youtube_embed_plugin_styles()
{
      wp_register_style("youtube-embed-css", plugins_url("otto-youtube-embed/otto-youtube-embed.css"));
      wp_enqueue_style("youtube-embed-css");
}
 
add_action("wp_enqueue_scripts", "register_youtube_embed_plugin_styles");


function youtube_shortcode_text_editor_script()
{
      if(wp_script_is("quicktags"))
      {
            ?>
                <script type="text/javascript">
       
                      QTags.addButton(
                            "youtube_shortcode",
                            "Youtube Embed",
                            youtube_callback
                        );
       
                      function youtube_callback()
                      {
                            var id = prompt("Please enter your video id");
         
                            if (id != null)
                            {
                                  QTags.insertContent('<div class="flex-video widescreen"><iframe width="425" height="344" src="http://www.youtube.com/embed/id="'+id+'"][/youtube?wmode=transparent" frameborder="0" allowfullscreen=""> </iframe></div>');
                            }
                      }
                </script>
            <?php
      }
}
 
add_action("admin_print_footer_scripts", "youtube_shortcode_text_editor_script");


function enqueue_mce_plugin_scripts($plugin_array)
{
      $plugin_array["youtube_button_plugin"] =  plugin_dir_url(__FILE__) . "mce.js";
      return $plugin_array;
}
 
add_filter("mce_external_plugins", "enqueue_mce_plugin_scripts");
 
function register_mce_buttons_editor($buttons)
{
      array_push($buttons, "youtube");
      return $buttons;
}
 
add_filter("mce_buttons", "register_mce_buttons_editor");