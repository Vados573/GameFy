<?php
require('includes/config.php');
require('includes/global_functions.php');
session_start();
if (!isset($_SESSION['id'])) {
    header("location:login-registration.php");
}
$sql = "SELECT id_user, fName_user, lName_user, description_user FROM user WHERE id_user = " . $_SESSION['id'];
$result = odbc_exec($con, $sql);
$table = odbc_fetch_object($result);
$firstName = $table->fName_user;
$lastName = $table->lName_user;
$description = $table->description_user;
?>
<html lang="en">
<head>
    <title>Gamify</title>
    <?php require('includes/head.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<?php require('includes/sidebar.php'); ?>
<div id="beeteam368-site-wrap-parent" class="beeteam368-site-wrap-parent beeteam368-site-wrap-parent-control">
    <?php require('includes/header.php'); ?>
    <div id="beeteam368-primary-cw" class="beeteam368-primary-cw">
        <div class="site__container main__container-control">
            <div id="sidebar-direction" class="site__row flex-row-control sidebar-direction">
                <main id="main-content" class="site__col main-content global-post-page-content">
                    <article id="post-0" class="post-0 page type-page status-publish hentry">
                        <header class="entry-header single-page-title">
                            <h1 class="entry-title h1-single">Profile</h1></header>
                        <h2 class="h1 h3-mobile profile-section-title">Update Your Profile</h2>
                        <div class="tml tml-update-profile">
                            <div class="tml-alerts profile-section-alerts-control"></div>
                            <form name="update-profile" class="form-profile-control" method="post"
                                  enctype="multipart/form-data">
                                <div class="tml-field-wrap tml-user_email-wrap">
                                    <label class="tml-label" for="user_email">Email *</label>
                                    <input name="user_email" type="email" value="<?php echo $_SESSION['email'] ?>"
                                           id="user_email" class="tml-field" placeholder="E-mail" autocomplete="off"
                                           style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;); cursor: auto;">
                                </div>
                                <div class="tml-field-wrap tml-first_name-wrap">
                                    <label class="tml-label" for="first_name">First Name</label>
                                    <?php
                                    if ($firstName == "") {
                                        ?>
                                        <input name="first_name" type="text" value="" id="first_name"
                                               class="tml-field" placeholder="First Name">
                                        <?php
                                    } else {
                                        ?>
                                        <input name="first_name" type="text" value="<?php echo $firstName ?>"
                                               id="first_name"
                                               class="tml-field" placeholder="">
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="tml-field-wrap tml-last_name-wrap">
                                    <label class="tml-label" for="last_name">Last Name</label>
                                    <?php
                                    if ($lastName == "") {
                                        ?>
                                        <input name="last_name" type="text" value="" id="last_name"
                                               class="tml-field"
                                               placeholder="Last Name">
                                        <?php
                                    } else {
                                        ?>
                                        <input name="last_name" type="text" value="<?php echo $lastName ?>"
                                               id="last_name"
                                               class="tml-field"
                                               placeholder="">
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="tml-field-wrap tml-nickname-wrap">
                                    <label class="tml-label" for="nickname">Nickname [display name] *</label>
                                    <input name="nickname" type="text" value="<?php echo $_SESSION['username'] ?>"
                                           id="nickname" class="tml-field" placeholder="">
                                </div>
                                <div class="tml-field-wrap tml-biography-wrap">
                                    <label class="tml-label" for="description">Biographical Info</label>
                                    <textarea name="description" id="description" rows="5" cols="30"
                                              class="tml-field"><?php echo $description;?></textarea>
                                </div>
                                <div class="tml-field-wrap">
                                    <p class="description">Click the button below to update your profile.</p>
                                </div>
                                <div class="tml-field-wrap tml-submit-wrap">
                                    <button name="submit" type="button"
                                            class="tml-button loadmore-btn update-profile-control">
                                        <span class="loadmore-text loadmore-text-control">Update Profile</span>
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
                        <hr class="space-section">
                        <h2 class="h1 h3-mobile profile-section-title">Update Your Avatar &amp; Channel Banner</h2>
                        <div class="tml tml-update-avatar">
                            <div class="tml-alerts avatar-section-alerts-control"></div>
                            <form name="update-avatar" class="form-avatar-control" method="post"
                                  enctype="multipart/form-data">
                                <div class="tml-field-wrap tml-avatar-wrap tml-avatar-wrap-control">
                                    <div class="abs-img abs-img-control">
                                        <img alt="Author Avatar"
                                             src="https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=61&amp;d=mm&amp;r=g"
                                             sizes="(max-width: 61px) 100vw, 61px"
                                             srcset="https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=61&amp;d=mm&amp;r=g 61w, https://secure.gravatar.com/avatar/83232f25bace98c04afdba2ef9eedd8d?s=122&amp;d=mm&amp;r=g 122w"
                                             class="author-avatar" width="61" height="61"> <span
                                                class="remove-img-profile remove-img-profile-control"
                                                data-action="avatar"><i class="fas fa-times-circle"></i></span>
                                    </div>
                                    <label class="tml-label" for="avatar">Avatar</label>
                                    <input type="file" name="avatar" id="avatar" size="40" accept=".gif,.png,.jpg,.jpeg"
                                           aria-invalid="false">
                                    <p class="description">Recommended size 122(px) x 122(px). Maximum upload file size:
                                        3MB.</p>
                                </div>
                                <div class="tml-field-wrap tml-channel-banner-wrap tml-channel-banner-wrap-control">
                                    <div class="abs-img abs-img-control">
                                        <span class="remove-img-profile remove-img-profile-control"
                                              data-action="channel_banner"><i class="fas fa-times-circle"></i></span>
                                    </div>
                                    <label class="tml-label" for="channel_banner">Channel Banner</label>
                                    <input type="file" name="channel_banner" id="channel_banner" size="40"
                                           accept=".gif,.png,.jpg,.jpeg" aria-invalid="false">
                                    <p class="description">Recommended size 1920(px) x 500(px). Maximum upload file
                                        size: 3MB.</p>
                                </div>
                                <div class="tml-field-wrap">
                                    <p class="description">Click the button below to update your avatar.</p>
                                </div>
                                <div class="tml-field-wrap tml-submit-wrap">
                                    <button name="submit" type="button"
                                            class="tml-button loadmore-btn update-avatar-control">
                                        <span class="loadmore-text loadmore-text-control">Update Avatar</span>
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
                        <hr class="space-section">
                        <h2 class="h1 h3-mobile profile-section-title">Update Your Password</h2>
                        <div class="tml tml-update-profile">
                            <div class="tml-alerts password-section-alerts-control"></div>
                            <form name="update-password" class="form-password-control" method="post"
                                  enctype="multipart/form-data">
                                <div class="tml-field-wrap tml-user_pass1-wrap">
                                    <label class="tml-label" for="pass1">New Password *</label>
                                    <input name="user_pass1" type="password" id="pass1" autocomplete="off"
                                           class="tml-field"
                                           style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);">
                                </div>
                                <div class="tml-field-wrap tml-user_pass2-wrap">
                                    <label class="tml-label" for="pass2">Confirm New Password *</label>
                                    <input name="user_pass2" type="password" id="pass2" autocomplete="off"
                                           class="tml-field"
                                           style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGP6zwAAAgcBApocMXEAAAAASUVORK5CYII=&quot;);">
                                </div>
                                <div class="tml-field-wrap tml-indicator-wrap">
<!--                                    <div id="pass-strength-result" class="hide-if-no-js strong" aria-live="polite">-->
<!--                                        Strong-->
<!--                                    </div>-->
                                </div>
                                <div class="tml-field-wrap tml-indicator_hint-wrap">
                                    <p class="description indicator-hint">Hint: The password should be at least twelve
                                        characters long. To make it stronger, use upper and lower case letters, numbers,
                                        and symbols like ! " ? $ % ^ &amp; ).</p>
                                </div>
                                <div class="tml-field-wrap tml-submit-wrap">
                                    <button name="submit" type="button"
                                            class="tml-button loadmore-btn update-password-control">
                                        <span class="loadmore-text loadmore-text-control">Update Password</span>
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
                    </article>
                </main>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
</div>
<?php require('includes/scripts.php'); ?>
</body>