<div class="beeteam368-global-popup beeteam368-submit-post-popup beeteam368-global-popup-control flex-row-control flex-vertical-middle flex-row-center"
     data-popup-id="submit_post_add_popup">
    <div class="beeteam368-global-popup-content beeteam368-global-popup-content-control"><span
                class="beeteam368-icon-item beeteam368-popup-close beeteam368-popup-close-control"><i
                    class="fas fa-times"></i></span>
        <div class="top-section-title has-icon">
            <span class="beeteam368-icon-item"><i class="fas fa-cloud-upload-alt"></i></span>
            <span class="sub-title font-main">For Creators</span>
            <h2 class="h2 h3-mobile main-title-heading">
                <?php if (isset($_SESSION['has_channel'])) {
                    if ($_SESSION['has_channel'] == 0) {
                        ?>
                        <span class="main-title">Create your Channel</span><span class="hd-line"></span>
                        <?php
                    } else {
                        ?>
                        <span class="main-title">Create an Event</span><span class="hd-line"></span>
                        <?php
                    }
                } else {
                    ?>
                    <span class="main-title">Create your Channel</span><span class="hd-line"></span>
                    <?php
                }
                ?>
            </h2>
        </div>
        <hr>
        <div class="loading-container loading-control abslt">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
        <div class="beeteam368-submit-post-add-wrapper beeteam368-submit-post-add-wrapper-control os-host os-theme-dark os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition"
             id="submit-post-add-53596">
            <div class="os-resize-observer-host observed">
                <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
            </div>
            <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
                <div class="os-resize-observer"></div>
            </div>
            <div class="os-content-glue" style="margin: 0px -40px; height: 1330px; width: 967px;"></div>
            <div class="os-padding">
                <div class="os-viewport os-viewport-native-scrollbars-invisible os-viewport-native-scrollbars-overlaid"
                     style="overflow-y: scroll;">
                    <div class="os-content" style="padding: 0px 40px; height: auto; width: 100%;">
                        <?php
                        if (!isset($_SESSION['id'])) {
                            ?>
                            <div class="form-submit-add-alerts form-submit-add-alerts-control font-size-12">
                                <span>You need to login to create a channel, an event, or a blog.</span>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="form-submit-add-alerts form-submit-add-alerts-control font-size-12"
                                 style="display: none">
                                <span id="alert_popup"></span>
                            </div>
                            <?php

                        }
                        ?>
                        <div class="btn-mode-upload">
                            <?php if (isset($_SESSION['has_channel'])) {
                                if ($_SESSION['has_channel'] == 0) {
                                    ?>
                                    <button type="button" class="small-style reverse btn-mode-submit-control active-item"
                                            data-mode="video">
                                        <i class="icon fas fa-tv"></i><span>Channel</span></button>
                                    <button type="button" class="small-style reverse btn-mode-submit-control" data-mode="audio"><i class="icon fas fa-calendar"></i><span>Event</span></button>
                                    <button type="button" class="small-style reverse btn-mode-submit-control" data-mode="post"><i class="icon fas fa-blog"></i><span>Blog</span></button>
                                    <?php
                                }
                                else{
                                    ?>
                                                                <button type="button" class="small-style reverse btn-mode-submit-control active-item" data-mode="audio"><i class="icon fas fa-calendar"></i><span>Event</span></button>
                                                                <button type="button" class="small-style reverse btn-mode-submit-control" data-mode="post"><i class="icon fas fa-blog"></i><span>Blog</span></button>
                            <?php
                                }
                            }
                            else{
                                ?>
                                <button type="button" class="small-style reverse btn-mode-submit-control active-item"
                                        data-mode="channel">
                                    <i class="icon fas fa-tv"></i><span>Channel</span></button>
                                <button type="button" class="small-style reverse btn-mode-submit-control" data-mode="post"><i class="icon fas fa-calendar"></i><span>Event</span></button>
                                <button type="button" class="small-style reverse btn-mode-submit-control" data-mode="post"><i class="icon fas fa-blog"></i><span>Blog</span></button>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        if (isset($_SESSION['id'])) {
                            if (isset($_SESSION['has_channel'])) {
                                if ($_SESSION['has_channel'] == 0) {
                                    ?>
                                    <div class="form-submit-wrapper dropzone">
                                        <form name="submit-add-posts" class="form-submit-add-control" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" name="s_post_type" class="post-type-control"
                                                   value="post">
                                            <input type="hidden" name="media_type" class="media-type-control"
                                                   value="upload">
                                            <input type="hidden" name="media_data" class="media-data-control" value="">
                                            <label class="h1 section-title-media-control" style="display: none;">Primary
                                                Source</label>
                                            <div class="data-item btn-mode-upload switch-source-wrap-control"
                                                 style="display: none;">
<span class="beeteam368-icon-item primary-color-focus tooltip-style bottom-center btn-mode-source-control"
      data-source="upload">
<i class="fas fa-upload"></i><span class="tooltip-text">Upload</span>
</span>
                                                <span class="beeteam368-icon-item tooltip-style bottom-center btn-mode-source-control"
                                                      data-source="external">
<i class="fas fa-external-link-alt"></i><span class="tooltip-text">External Link</span>
</span>
                                            </div>
                                            <div class="media-upload-hide-control media_upload_container"
                                                 style="display: none;">
                                                <label class="h5">Media File Upload</label>
                                                <em class="data-item-desc font-size-12">Supports: *.mp4, *.m4v, *.webm,
                                                    *.ogv.
                                                    Maximum upload file size: 10mb. You can change the upload size in
                                                    "Theme
                                                    Settings".</em>
                                                <div class="beeteam368_media_upload beeteam368_media_upload-control dropzone_Installed">
                                                    <span class="beeteam368-icon-item"><i
                                                                class="fas fa-upload"></i></span>
                                                    <div class="text-upload-dd">Drag and drop video/audio file to
                                                        upload
                                                    </div>
                                                    <button type="button"
                                                            class="small-style beeteam368_media_upload-btn-control dz-clickable">
                                                        <i class="icon fas fa-upload"></i><span>Select File</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="media-upload-hide-control media_upload_preview media_upload_preview_control"
                                                 style="display: none;"></div>
                                            <div class="data-item external-link-hide-control is-temp-hidden"
                                                 style="display: none;">
                                                <label for="post_media_url" class="h5">Media URL/Embed</label>
                                                <textarea name="post_media_url" id="post_media_url"
                                                          placeholder="Enter the media's external link or embed."
                                                          rows="3"></textarea>
                                            </div>
                                            <div class="video-ratio-hide-control data-item" style="display: none;">
                                                <label for="player_ratio" class="h5">Video Resolution &amp; Aspect
                                                    Ratio</label>
                                                <input type="text" name="player_ratio" id="player_ratio"
                                                       placeholder="Default: &quot; 16:9 &quot; - You can change the aspect ratio of this video to &quot; 2:3 &quot;, &quot; 21:9 &quot;, ... or &quot; auto &quot;"
                                                       style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);">
                                            </div>
                                            <input type="hidden" name="preview_media_type" class="preview-type-control"
                                                   value="upload">
                                            <input type="hidden" name="preview_data" class="preview-data-control"
                                                   value="">
                                            <label class="h1 section-title-media-control" style="display: none;">Preview/Demo
                                                File</label>
                                            <div class="data-item btn-mode-upload switch-source-wrap-control"
                                                 style="display: none;">
<span class="beeteam368-icon-item primary-color-focus tooltip-style bottom-center btn-preview-mode-source-control"
      data-source="upload">
<i class="fas fa-upload"></i><span class="tooltip-text">Upload</span>
</span>
                                                <span class="beeteam368-icon-item tooltip-style bottom-center btn-preview-mode-source-control"
                                                      data-source="external">
<i class="fas fa-external-link-alt"></i><span class="tooltip-text">External Link</span>
</span>
                                            </div>
                                            <div class="preview-upload-hide-control media_upload_container"
                                                 style="display: none;">
                                                <label class="h5">Preview/Demo File Upload</label>
                                                <em class="data-item-desc font-size-12">Preview/Demo File Upload</em>
                                                <div class="beeteam368_media_upload beeteam368_preview_upload-control dropzone_Installed">
                                                    <span class="beeteam368-icon-item"><i class="fas fa-eye"></i></span>
                                                    <div class="text-upload-dd">Drag and drop video/audio file to
                                                        upload
                                                    </div>
                                                    <button type="button"
                                                            class="small-style beeteam368_preview_upload-btn-control dz-clickable">
                                                        <i class="icon fas fa-eye"></i><span>Select File</span></button>
                                                </div>
                                            </div>
                                            <div class="media_upload_preview preview_upload_preview_control"></div>
                                            <div class="data-item is-temp-hidden preview-external-link-hide-control"
                                                 style="display: none;">
                                                <label for="post_preview_media_url" class="h5">Preview/Demo
                                                    [URL/Embed]</label>
                                                <textarea name="post_preview_media_url" id="post_preview_media_url"
                                                          placeholder="Enter the media's external link or embed."
                                                          rows="3"></textarea>
                                            </div>
                                            <!--                                <div class="section-video-sell-control is-temp-hidden">-->
                                            <!--                                    <label class="h1">Video - Pay Per View</label>-->
                                            <!--                                    <div class="data-item">-->
                                            <!--                                        <label for="post_video_sell_price" class="h5">Purchase Price</label>-->
                                            <!--                                        <em class="data-item-desc font-size-12">If you want to sell access to this content, enter the sale price for it. FREE = 0 or blank</em>-->
                                            <!--                                        <input type="number" min="1" step="1" name="post_video_sell_price" id="post_video_sell_price" placeholder="1">-->
                                            <!--                                    </div>-->
                                            <!--                                    <div class="data-item">-->
                                            <!--                                        <label for="post_video_sell_expiration" class="h5">Expiration</label>-->
                                            <!--                                        <em class="data-item-desc font-size-12">The default is 0, this is the expiration time to view that content after purchase. No expiration = 0 or blank</em>-->
                                            <!--                                        <input type="number" min="1" step="1" name="post_video_sell_expiration" id="post_video_sell_expiration" placeholder="0">-->
                                            <!--                                    </div>-->
                                            <!--                                    <hr>-->
                                            <!--                                </div>-->
                                            <!--                                <div class="section-audio-sell-control is-temp-hidden">-->
                                            <!--                                    <label class="h1">Audio - Pay Per Listen</label>-->
                                            <!--                                    <div class="data-item">-->
                                            <!--                                        <label for="post_audio_sell_price" class="h5">Purchase Price</label>-->
                                            <!--                                        <em class="data-item-desc font-size-12">If you want to sell access to this content, enter the sale price for it. FREE = 0 or blank</em>-->
                                            <!--                                        <input type="number" min="1" step="1" name="post_audio_sell_price" id="post_audio_sell_price" placeholder="1">-->
                                            <!--                                    </div>-->
                                            <!--                                    <div class="data-item">-->
                                            <!--                                        <label for="post_audio_sell_expiration" class="h5">Expiration</label>-->
                                            <!--                                        <em class="data-item-desc font-size-12">The default is 0, this is the expiration time to view that content after purchase. No expiration = 0 or blank</em>-->
                                            <!--                                        <input type="number" min="1" step="1" name="post_audio_sell_expiration" id="post_audio_sell_expiration" placeholder="0">-->
                                            <!--                                    </div>-->
                                            <!--                                    <hr>-->
                                            <!--                                </div>-->
                                            <div class="section-post-sell-control">
                                                <label class="h1">Customize your channel</label>
                                                <div class="data-item">
                                                    <label for="post_sell_price" class="h5">Name of your
                                                        channel:</label>
                                                    <em class="data-item-desc font-size-12">Choose the name of your
                                                        channel
                                                        wisely as you can't change it later!</em>
                                                    <input type="text" name="name_channel" id="name_channel"
                                                           placeholder="Name of your channel" spellcheck="false">
                                                </div>
                                                <div class="data-item">
                                                    <label for="post_sell_expiration" class="h5">Description of your
                                                        channel:</label>
                                                    <em class="data-item-desc font-size-12">Describe yourself and your
                                                        channel
                                                        to let people know you and what you will be sharing on your
                                                        channel</em>
                                                    <textarea name="description_channel" id="description_channel"
                                                              class="description_channel"
                                                              placeholder="Description of your channel"
                                                              spellcheck="false"></textarea>
                                                </div>
                                                <hr>
                                            </div>
                                            <!--                                <div class="data-item">-->
                                            <!--                                    <label for="post_title" class="h5">Post Title</label>-->
                                            <!--                                    <input type="text" name="post_title" id="post_title" placeholder="Enter the title of the post">-->
                                            <!--                                </div>-->
                                            <!--                                <div class="data-item">-->
                                            <!--                                    <label for="post_tags" class="h5">Post Tags</label>-->
                                            <!--                                    <input type="text" name="post_tags" id="post_tags" placeholder="Enter comma-separated values">-->
                                            <!--                                </div>-->
                                            <!--                                <div class="data-sub-item section-video-sell-control is-temp-hidden">-->
                                            <!--                                    <div class="data-item">-->
                                            <!--                                        <label for="video_categories" class="h5">Video Categories</label>-->
                                            <!--                                        <select id="video_categories" data-placeholder="Select a Category" class="beeteam368-select-multiple select-multiple-control select2-hidden-accessible" name="beeteam368-submit-video-categories[]" multiple="" tabindex="-1" aria-hidden="true" data-select2-id="video_categories"><option value="4">Entertainment</option><option value="5">Gaming</option><option value="7">Movies</option><option value="6">Sports</option></select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="17" style="width: 32px;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false"><ul class="select2-selection__rendered"><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="Select a Category" style="width: 786px;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>-->
                                            <!--                                    </div>-->
                                            <!--                                </div>-->
                                            <!--                                <div class="data-sub-item section-audio-sell-control is-temp-hidden">-->
                                            <!--                                    <div class="data-item">-->
                                            <!--                                        <label for="audio_categories" class="h5">Audio Categories</label>-->
                                            <!--                                        <select id="audio_categories" data-placeholder="Select a Category" class="beeteam368-select-multiple select-multiple-control select2-hidden-accessible" name="beeteam368-submit-audio-categories[]" multiple="" tabindex="-1" aria-hidden="true" data-select2-id="audio_categories"><option value="10">Music</option></select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="19" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false"><ul class="select2-selection__rendered"><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="Select a Category" style="width: 0px;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>-->
                                            <!--                                    </div>-->
                                            <!--                                </div>-->
                                            <!--                                <div class="data-sub-item section-post-sell-control">-->
                                            <!--                                    <div class="data-item">-->
                                            <!--                                        <label for="post_categories" class="h5">Post Categories</label>-->
                                            <!--                                        <select id="post_categories" data-placeholder="Select a Category" class="beeteam368-select-multiple select-multiple-control select2-hidden-accessible" name="beeteam368-submit-post-categories[]" multiple="" tabindex="-1" aria-hidden="true" data-select2-id="post_categories"><option value="1">News</option></select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="21" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false"><ul class="select2-selection__rendered"><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="Select a Category" style="width: 0px;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>-->
                                            <!--                                    </div>-->
                                            <!--                                </div>-->
                                            <div class="media_upload_container">
                                                <label class="h5">Image of your channel:</label>
                                                <em class="data-item-desc font-size-12">Supports: *.png, *.jpg, *.jpeg.
                                                    Maximum
                                                    upload file size: 5mb</em>
                                                <div class="beeteam368_media_upload beeteam368_featured_image_upload-control dropzone_Installed">
                                            <span class="beeteam368-icon-item" id="upload_icon"><i
                                                        class="far fa-image"></i></span>
                                                    <div class="text-upload-dd">Drag and drop image file to upload</div>
                                                    <!--                                            <button type="button"-->
                                                    <!--                                                    class="small-style beeteam368_featured_image_upload-btn-control dz-clickable">-->
                                                    <!--                                                <i class="icon far fa-image"></i><span>Select Image</span></button>-->
                                                    <label for="channel_image" id="channel_image_label">
                                                        Select Image
                                                    </label>
                                                    <input name="channel_image" type="file" id="channel_image"
                                                           style="display: none"
                                                           accept="image/png, image/jpg, image/jpeg"/>
                                                </div>
                                            </div>
                                            <div class="media_upload_preview featured_image_upload_preview_control"></div>
                                            <!--                                <div class="data-item">-->
                                            <!--                                    <label for="post_descriptions" class="h5">Post Descriptions</label>-->
                                            <!--                                    <textarea name="post_descriptions" id="post_descriptions" placeholder="Post Descriptions" rows="5"></textarea>-->
                                            <!--                                </div>-->
                                            <div class="data-item">
                                                <button name="submit" type="button"
                                                        class="loadmore-btn beeteam368_post-add-control"
                                                        id="create_channel">
                                                    <span class="loadmore-text loadmore-text-control">Create Channel</span>
                                                    <span class="loadmore-loading">
<span class="loadmore-indicator">
 <svg><polyline class="lm-back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline> <polyline class="lm-front"
                                                                                           points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline></svg>
</span>
</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
                <div class="os-scrollbar-track os-scrollbar-track-off">
                    <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px);"></div>
                </div>
            </div>
            <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
                <div class="os-scrollbar-track os-scrollbar-track-off">
                    <div class="os-scrollbar-handle" style="height: 27.594%; transform: translate(0px);"></div>
                </div>
            </div>
            <div class="os-scrollbar-corner"></div>
        </div>
    </div>
</div>