<?php
/**
 * Tatoeba Project, free collaborative creation of multilingual corpuses project
 * Copyright (C) 2009  HO Ngoc Phuong Trang <tranglich@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Tatoeba
 * @author   HO Ngoc Phuong Trang <tranglich@gmail.com>
 * @license  Affero General Public License
 * @link     http://tatoeba.org
 */
?>
<!DOCTYPE html>
<html lang="<?php echo LanguagesLib::languageTag(Configure::read('Config.language')); ?>">
<head>
    <?php echo $html->charset(); ?>
    <title><?php echo $title_for_layout; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
    <?php
    echo $html->meta('icon');

    // ---------------------- //
    //          CSS           //
    // ---------------------- //
    // Only two CSS files are loaded. One that is generic, and one that is
    // specific to the view. The specific CSS file is auto-loaded. It must be
    // named with name of the view it is linked to, and put it in a folder with
    // the name of the controller.

    // Generic
    echo $html->css(CSS_PATH . 'layouts/responsive.css');
    echo $html->css(CSS_PATH . 'layouts/elements.css');

    // Specific
    $controller = $this->params["controller"];
    $action = $this->params["action"];
    echo $html->css(CSS_PATH . $controller."/".$action .".css");

    // Develop site override
    if (Configure::read('Tatoeba.devStylesheet')) { ?>
        <style>
            body {
                background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHdpZHRoPSczMDAnIGhlaWdodD0nMzAwJyB2aWV3Qm94PScwIDAgMzAwIDMwMCc+Cgk8ZGVmcz4KCQk8cGF0dGVybiBpZD0nYmx1ZXN0cmlwZScgcGF0dGVyblVuaXRzPSd1c2VyU3BhY2VPblVzZScgeD0nMCcgeT0nMCcgd2lkdGg9JzIwJyBoZWlnaHQ9JzIwJyB2aWV3Qm94PScwIDAgNDAgNDAnID4KCQk8cmVjdCB3aWR0aD0nMTEwJScgaGVpZ2h0PScxMTAlJyBmaWxsPScjZmZmZmZmJy8+CgkJCTxwYXRoIGQ9J00xLDFoNDB2NDBoLTQwdi00MCcgZmlsbC1vcGFjaXR5PScwJyBzdHJva2Utd2lkdGg9JzEnIHN0cm9rZS1kYXNoYXJyYXk9JzAsMSwxJyBzdHJva2U9JyNjY2NjY2MnLz4KCQk8L3BhdHRlcm4+IAoJCTxmaWx0ZXIgaWQ9J2Z1enonIHg9JzAnIHk9JzAnPgoJCQk8ZmVUdXJidWxlbmNlIHR5cGU9J3R1cmJ1bGVuY2UnIHJlc3VsdD0ndCcgYmFzZUZyZXF1ZW5jeT0nLjIgLjMnIG51bU9jdGF2ZXM9JzUnIHN0aXRjaFRpbGVzPSdzdGl0Y2gnLz4KCQkJPGZlQ29sb3JNYXRyaXggdHlwZT0nc2F0dXJhdGUnIGluPSd0JyB2YWx1ZXM9JzAnLz4KCQk8L2ZpbHRlcj4KCTwvZGVmcz4KCTxyZWN0IHdpZHRoPScxMDAlJyBoZWlnaHQ9JzEwMCUnIGZpbGw9J3VybCgjYmx1ZXN0cmlwZSknLz4KPHJlY3Qgd2lkdGg9JzEwMCUnIGhlaWdodD0nMTAwJScgZmlsdGVyPSd1cmwoI2Z1enopJyBvcGFjaXR5PScwLjEnLz4KPC9zdmc+Cg==');
            }
            #top_menu_container { background-color: #cf0000; }
            #content .container:before {
                content: "<?php __("Warning: this website is for testing purposes. Everything you submit will be definitely lost.")?>";
                color: #cf0000;
                font-size: 15px;
            }
        </style>
    <?php }
    echo $this->element('seo_international_targeting');
    ?>

    <link rel="search" type="application/opensearchdescription+xml"
          href="/opensearch.xml" title="Tatoeba" />
</head>
<body ng-app="app">
<div id="audioPlayer"></div>

<!--  TOP  -->
<?php echo $this->element('top_menu'); ?>

<!--  SEARCH BAR  -->
<?php
$isHomepage = $controller == 'pages' && $action == 'index';
if (CurrentUser::isMember() || !$isHomepage) {
    echo $this->element('search_bar', array(
        'selectedLanguageFrom' => $session->read('search_from'),
        'selectedLanguageTo' => $session->read('search_to'),
        'searchQuery' => $session->read('search_query'),
        'cache' => array(
            // Only use cache when search fields are not prefilled
            'time' => is_null($session->read('search_from'))
            && is_null($session->read('search_to'))
            && is_null($session->read('search_query'))
            && !$languages->preferredLanguageFilter()
                ? '+1 day' : false,
            'key' => Configure::read('Config.language')
        )
    ));
} else {
    echo $this->element('short_description', array(
        'cache' => array(
            'time' => '+1 day',
            'key' => Configure::read('Config.language')
        )
    ));
}
?>

<!--  CONTENT -->
<div id="content">
    <div class="container">
        <?php
        echo $this->element('announcement');
        if($session->check('Message.flash')){
            echo $session->flash();
        }

        echo $content_for_layout;
        ?>

        <!--
            Quick fix to readjust the size of the container when
            the main content is smaller than the annexe content.
        -->
        <div style="clear:both"></div>
    </div>
</div>

<!--  FOOT -->
<?php
echo $this->element('foot');
?>
<?php echo $this->element('sql_dump'); ?>

<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/jquery-1.11.3.min.js"><\/script>')</script>

<!-- Angular Material requires Angular.js Libraries -->
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>

<!-- Angular Material Library -->
<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>

<?php
echo $javascript->link(JS_PATH . 'generic_functions.js', true);
// Source: https://github.com/jonathantneal/svg4everybody
// This is needed to make "fill: currentColor" work on every browser.
echo $javascript->link(JS_PATH . 'svg4everybody.min.js', true);
if (CurrentUser::getSetting('copy_button')) {
    echo $javascript->link(JS_PATH . 'sentences.copy.js', true);
}

echo $responsive->js('app.module.js', true);
echo $scripts_for_layout;

if (Configure::read('GoogleAnalytics.enabled')) {
    echo $this->element('google_analytics', array('cache' => true));
}
?>
</body>
</html>
