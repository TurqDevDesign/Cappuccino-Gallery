<?php

function cappu_gallery_help_page(){
    ?>
    <style>

        .cappu-help {

            width: 100%;
            height: auto;
            margin: 15px 0 0 0;
            border-top: 1px solid lightgrey;

        }
        ul {

            margin: 0;
            padding: 0;

        }

        table.list {

            border: none;
            border-spacing: 0;

        }

        table.list tr {

            background: white;

        }

        table.list tr:nth-child(even) {

            background: #f7f7f7;

        }

        table.list td {

            padding: 5px 15px;

        }

        .help-section {

            margin: 0 0 50px 0;

        }

        .cg-help-image {

            max-width: 100%;
            max-height: 150px;

        }
    </style>
    <div class="wrap">
        <h1>Cappuccino Gallery Help</h1>
        Here is all the information you may need in order to use the Cappuccino Gallery plugin.
        <div class="cappu-help">
            <div class="help-section" id="adding_Images">
                <h2>Adding Images</h2>
                <p>Help with adding images.</p>
            </div>
            <div class="help-section" id="adding_videos">
                <h2>Adding Videos</h2>
                <p>Adding videos is simple, under <strong>Manage Gallery</strong>, on your sidebar, click <strong>Add new video</strong>. The new video interface will pop up, fill out all of the fields appropriately. </p>

                <p><strong>Where to find video link.</strong></p>
                <p>A video link can be obtained by simply visiting a youtube video and copying the text in the URL bar (highlighted below).</p>
                <img class="cg-help-image" src="<?php echo plugins_url('images/url.png',__FILE__) ?>" alt="Where to find video URL.">
                <p>Alternatively, if you have issues with the link in your URL bar, you can use the link provided under Youtube's share button. First, on a video page, click the share button (highlighted below).</p>
                <img class="cg-help-image" src="<?php echo plugins_url('images/share-button.png',__FILE__) ?>" alt="Where to find video URL.">
                <p>Next, making sure the 'share' tab is selected (it should have a red line under it), copy the link provided (highlighted below).</p>
                <img class="cg-help-image" src="<?php echo plugins_url('images/share-link.png',__FILE__) ?>" alt="Where to find video URL.">
            </div>
            <div class="help-section" id="gallery_info">
                <h2>Galleries</h2>
                <p>Gallery group information.</p>
            </div>
            <div class="help-section" id="shortcode_info">
                <h2>Shortcodes</h2>
                <strong>[cappuccino_gallery]</strong>
                <p>Cappuccino gallery ships with one shortcode, denoted above, with a variety of options. To use the shortcode simply place <em>[cappuccino_gallery]</em> in any page. By default, most options for the shortcode are located in the Cappuccino Gallery settings page (Under the Manage Gallery sidebar option). But if you have multiple different galleries that you'd like to have different settings, you can easily set those settings on the shortcode itself. The available options and their possible settings are as follows: </p>
                <table class="list">
                    <tbody>
                        <tr>
                            <td><em><strong>title             </strong></em></td>
                            <td>--&gt;</td>
                            <td><em>true</em> or <em>false</em></td>
                        </tr>
                        <tr>
                            <td><em><strong>subtitle          </strong></em></td>
                            <td>--&gt;</td>
                            <td><em>true</em> or <em>false</em></td>
                        </tr>
                        <tr>
                            <td><em><strong>caption           </strong></em></td>
                            <td>--&gt;</td>
                            <td><em>true</em> or <em>false</em></td>
                        </tr>
                        <tr>
                            <td><em><strong>desktop-columns   </strong></em></td>
                            <td>--&gt;</td>
                            <td><em>4</em> or <em>3</em> or <em>2</em> or <em>1</em></td>
                        </tr>
                        <tr>
                            <td><em><strong>tablet-columns    </strong></em></td>
                            <td>--&gt;</td>
                            <td><em>3</em> or <em>2</em> or <em>1</em></td>
                        </tr>
                        <tr>
                            <td><em><strong>mobile-columns    </strong></em></td>
                            <td>--&gt;</td>
                            <td><em>2</em> or <em>1</em></td>
                        </tr>
                        <tr>
                            <td><em><strong>sort-by           </strong></em></td>
                            <td>--&gt;</td>
                            <td><em>date added</em> or <em>abc</em></td>
                        </tr>
                        <tr>
                            <td><em><strong>sorting-direction </strong></em></td>
                            <td>--&gt;</td>
                            <td><em>asc</em> or <em>desc</em></td>
                        </tr>
                        <tr>
                            <td><em><strong>gallery          </strong></em></td>
                            <td>--&gt;</td>
                            <td><em>all</em> or any slug from the list of galleries you've created.</td>
                        </tr>
                    </tbody>
                </table>
                <p>As you may see, the <em>gallery</em> option is the only option not available on the settings page. This allows you to have multiple galleries, but only print the one you want to show. </p>
                <p>To add an option to the shortcode, simply write it in the form <em>[cappuccino_gallery&nbsp;&nbsp;option='value']</em>. For instance, if I wanted to show a gallery with a slug of <em>my-gallery</em>, and I didn't want to show the caption, I would write <em>[cappuccino_gallery&nbsp;&nbsp;gallery='my-gallery'&nbsp;&nbsp;caption='false']</em>. All other options will be decided by the defaults you've set on the settings page. </p>
            </div>
        </div>

    </div>

    <?php
}
