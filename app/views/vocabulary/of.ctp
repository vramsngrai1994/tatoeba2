<?php
$javascript->link('/js/responsive/vocabulary/of.ctrl.js', false);
$count = $paginator->counter('%count%');
?>

<div id="annexe_content">
    <?php echo $this->element('vocabulary/menu'); ?>

    <?php $commonModules->createFilterByLangMod(2); ?>
</div>

<div id="main_content" ng-controller="VocabularyOfController as ctrl">
    <div class="section" md-whiteframe="1">
        <h2>
        <?= format(
            __("{username}'s vocabulary items ({number})", $count, true),
            array('username' => $username, 'number' => $count)
        ); ?>
        </h2>

        <?php
        $paginationUrl = array($username);
        $pagination->display($paginationUrl);
        ?>

        <md-list flex>
            <?php
            foreach($vocabulary as $item) {
                $id = $item['Vocabulary']['id'];
                $divId = bin2hex($id);
                $lang = $item['Vocabulary']['lang'];
                $text = $item['Vocabulary']['text'];
                $numSentences = $item['Vocabulary']['numSentences'];
                $numSentencesLabel = $numSentences == 1000 ? '1000+' : $numSentences;
                $url = $html->url(array(
                    'controller' => 'sentences',
                    'action' => 'search',
                    '?' => array(
                        'query' => '="' . $text . '"',
                        'from' => $lang
                    )
                ));
                ?>
                <md-list-item id="vocabulary_<?= $divId ?>">
                    <img class="vocabulary-lang" src="/img/flags/<?= $lang ?>.png"/>
                    <div class="vocabulary-text" flex><?= $text ?></div>
                    <md-button class="md-primary" href="<?= $url ?>">
                        <?= format(
                            __n(
                                '{number} sentence', '{number} sentences',
                                $numSentences,
                                true
                            ),
                            array('number' => $numSentencesLabel)
                        ); ?>
                    </md-button>
                    <? if ($canEdit) { ?>
                        <md-button ng-click="ctrl.remove('<?= $divId ?>')"
                                   class="md-icon-button">
                            <md-icon aria-label="Remove">delete</md-icon>
                        </md-button>
                    <? } ?>
                </md-list-item>
                <?php
            }
            ?>
        </md-list>

        <?php
        $paginationUrl = array($username);
        $pagination->display($paginationUrl);
        ?>
    </div>

</div>
