<?php
class SuperTuxKartTemplate extends BaseTemplate {
    /**
     * This is function is used to create the entire page
     */
    public function execute() {
$admin_tools = array( array("name" => "Actions", "tools" => array("edit", "move", "purge","protect", "delete", "watch", "upload")),
                      array("name" => "Page",    "tools" => array("history", "whatlinkshere", "permalink", "info")),
                      array("name" => "Me",      "tools" => array("specialpages", "preferences", "watchlist", "mycontris", "logout")));

$user_tools = array("history", "whatlinkshere", "permalink", "info", "specialpages", "login");

$all_tools = array_merge($this->getPersonalTools(), $this->data['content_actions'], $this->getToolbox());

// TODO s. #3
/**
<?php if ($this->data['language_urls'] and count($this->data['language_urls']) > 0) { ?>
    <ul>
    <?php foreach ($this->data['language_urls'] as $key => $item) {
        echo $this->makeListItem($key, $item);
    } ?>
    </ul>
<?php } ?>
*/

// Even goole didn't know a better to do that ...
$logged_in = false;
foreach ($all_tools as $key => $item ) {
    if ($key == "logout") {
        $logged_in = true;
    }
}

$this->html('headelement');
?>

<div class="outerbox"> <!-- currently unused -->

<?php /* - Header ---------------------------------------------------------------------------- */ ?>
<div class="header_wrapper">
<div class="header_color_wrapper_outer">
<div class="header_color_wrapper_inner size-dependend-margin">
<div class="navigation-tools">
    <nav>
        <label for="toggle-mobile-navbar" class="toggle-mobile-navbar"><i class="fa fa-bars" style="margin-right: 5px"></i>Menu</label>
        <input type="checkbox" role="button" id="toggle-mobile-navbar" class="dropdown-trigger">
        <ul class="nav noselect dropdown-target">
            <li><a href="/Discover" >Discover </a></li>
            <li><a href="/Download" >Download </a></li>
            <li><a href="/FAQ"      >FAQ      </a></li>
            <li><a href="/Community">Get Involved</a></li>
            <li><a href="http://stkblog.net">Blog</a></li>
            <li><a class="donate-top-menu-link" href="/Donate">Donate &hearts;</a></li>
            <li class="searchform">
                <div class="toolbox-container">
                    <label for="toolbox-gear" class="toolbox-gear-label"><i class="fa fa-cog fa-lg"></i></label>
                    <input type="checkbox" role="button" id="toolbox-gear" class="dropdown-trigger"/>
                    <div class="toolbox dropdown-target"> <!-- the actual toolbox starts here -->
                        <p class="toolbox-title">Tools</p>

                        <?php
                        if ($logged_in) {
                            foreach ($admin_tools as $tool) { ?>
                                <div class="toolbox-section">
                                <p><?= $tool["name"] ?></p>
                                <ul>
                                <?php
                                foreach ($tool["tools"] as $toolname) {
                                    foreach ($all_tools as $key => $item ) {
                                        if ($key == $toolname) {
                                            echo $this->makeListItem($key, $item);
                                        }
                                    }
                                }
                                ?>
                                </ul>
                                </div>
                            <?php }
                        } else { ?>
                            <ul class="public-tools">
                            <?php
                            foreach ($user_tools as $toolname) {
                                foreach ($all_tools as $key => $item ) {
                                    if ($key == $toolname) {
                                        echo $this->makeListItem($key, $item);
                                    }
                                }
                            }
                            ?>
                            </ul>
                        <?php
                        } ?>

                    </div> <!-- the actual toolbox ends here -->
                </div>

                <form action="<?php $this->text('wgScript'); ?>">
                    <input type="hidden" name="title" value="<?php $this->text('searchtitle') ?>" />
                    <?php echo $this->makeSearchInput(array('type' => 'text')); ?>
                    <button class="fa fa-search" role="submit"></button>
                </form>
            </li>
        </ul>
    </nav>

    <a class="logo noselect"
        href="<?php echo htmlspecialchars($this->data['nav_urls']['mainpage']['href']) ?>"
        <?php echo Xml::expandAttributes(Linker::tooltipAndAccesskeyAttribs('p-logo')) ?>
    >
        <img src="<?php $this->text('logopath') ?>" alt="<?php $this->text('sitename') ?>" />
    </a>


</div>
</div>
</div>
</div>


<?php /* - Main Content ---------------------------------------------------------------------- */ ?>
<div class="main-content-wrapper size-dependend-margin">

<div class="content_wrapper">

<?php /* Main Content ----------------------------------------------------------------------- */ ?>

<?php if ($this->data['title'] != 'Main Page') { ?>
    <h1 class="article-title"><?php $this->html('title') ?></h1>
<?php } ?>
<article>
<?php $this->html('bodytext') ?>
<div id="section-donate-form" style="display:none;">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
	<label for="amount">Select the amount you wish to donate:</label> 
	<input type="text" value="10" name="amount" id="amount" style="width:75px"/> $AUD

	<br/>
	<i>Note: please be aware that paypal keeps a certain fee for any donations. Since PayPal takes a portion of the payment as fees, 
	we recommend donating at least US$2. If you have donated US$5 or more in the past, please contact us, and you will get this new 
	package without having to make a new donation.
	</i>

	<!--
	<label for="amount">Select the amount you wish to donate:</label> 
	<select name="amount" id="amount">
	<option value="5.00">$5.00</option>
	<option value="10.00" selected="selected">$10.00</option>
	<option value="15.00">$15.00</option>
	<option value="20.00">$20.00</option>
	<option value="25.00">$25.00</option>
	<option value="30.00">$30.00</option>
	<option value="40.00">$40.00</option>
	<option value="50.00">$50.00</option>
	<option value="75.00">$75.00</option>
	<option value="100.00">$100.00</option>
	</select>
	-->
	<br/><br/>
	<input type="hidden" name="cmd" value="_donations">
	<input type="hidden" name="business" value="B25GVW5NDLDHN">
	<input type="hidden" name="lc" value="AU">
	<input type="hidden" name="item_name" value="SuperTuxKart">
	<input type="hidden" name="currency_code" value="AUD">
	<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
	<input type="hidden" name="return" value="http://supertuxkart.sourceforge.net/donation_complete.php"/>
	<input type="image" src="https://www.paypalobjects.com/en_AU/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
	</form>
</div>
</article>
</div>

</div>

</div> <!-- main-content-wrapper -->


<?php /* - Footer (copyright section, various menu etc) -------------------------------------- */ ?>
<footer class="size-dependend-margin ">

<div class="footer-links">
<?php

// Data to be displayed at the end
$footer_section = array (
    array( 'heading' => 'Community', 'entries' => array (
        array('Forum', 'http://forum.freegamedev.net/viewforum.php?f=16'),
        array('Blog', 'http://supertuxkart.blogspot.com/'),
        array('Twitter', 'https://twitter.com/supertuxkart'),
        array('Addons', 'http://addons.supertuxkart.net/'),
        array('irc: #stk@freenode', 'http://webchat.freenode.net?channels=%23stk&uio=d4')
    )),
    array( 'heading' => 'Media', 'entries' => array (
        array('YouTube', 'https://www.youtube.com/channel/UCJ9hmn6MG_ggpQUhmbMS2mQ'),
        array('Pictures', '/Pictures'),
        array('Posters', '/Posters')
    )),
    array( 'heading' => 'Development', 'entries' => array (
        array('Modding', '/Track_Maker%27s_Guide'),
        array('GitHub', 'https://github.com/supertuxkart/stk-code'),
        array('Documentation', 'http://supertuxkart.sourceforge.net/doxygen')
    )),
    array( 'heading' => 'About us', 'entries' => array (
        array('FAQ', '/FAQ'),
        array('Who we are', '/Team'),
        array('About SuperTuxKart', '/Discover'),
        array('Projects using SuperTuxKart', '/Projects'),
    ))
);
?>

<?php
// This loop makes the link footer link table
foreach ($footer_section as $column) { ?>
    <div><p> <?= $column['heading'] ?> </p>
    <ul>

    <?php // Generating table cell
    foreach ($column['entries'] as $entry) { ?>
        <li><a href='<?= $entry[1] ?>'> <?= $entry[0] ?> </a></li>
    <?php } ?>

    </ul>
    </div>
<?php } ?>
</div>

<div class="footer-copyright">
Site designed by Jean-Manuel Cl&eacute;men&ccedil;on & Konstin<br />
Powered by <a href="https://www.mediawiki.org/wiki/MediaWiki">MediaWiki</a><br /><br />

SuperTuxKart Team © 2016
</div>

</footer>

<?php $this->printTrail(); // includes scripts etc. ?>

</body>
</html><?php
    }
}

?>
