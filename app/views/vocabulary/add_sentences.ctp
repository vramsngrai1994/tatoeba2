<?php
$javascript->link('/js/responsive/vocabulary/add-sentences.ctrl.js', false);
?>

<div id="annexe_content">
    <?php echo $this->element('vocabulary/menu'); ?>

    <?php $commonModules->createFilterByLangMod(); ?>
</div>

<div id="main_content" ng-controller="VocabularyAddSentencesController as ctrl">
    <div class="section" md-whiteframe="1">
        <h2><? __('Vocabulary that needs sentences'); ?></h2>

        <p>
            <?
            __(
                'Only vocabulary items that have less than 10 sentences are '.
                'displayed here.'
            )
            ?>
        </p>
        <?php
        $paginationUrl = array($lang);
        $pagination->display($paginationUrl);
        ?>

        <md-list flex>
            <?php
            foreach($vocabulary as $item) {
                $id = $item['Vocabulary']['id'];
                $hexId = bin2hex($id);
                $lang = $item['Vocabulary']['lang'];
                $text = $item['Vocabulary']['text'];
                $numSentences = $item['Vocabulary']['numSentences'];
                $url = $html->url(array(
                    'controller' => 'sentences',
                    'action' => 'search',
                    '?' => array(
                        'query' => '="' . $text . '"',
                        'from' => $lang
                    )
                ));
                ?>
                <md-list-item id="vocabulary_<?= $hexId ?>">
                    <img class="vocabulary-lang" src="/img/flags/<?= $lang ?>.png"/>
                    <div class="vocabulary-text" flex><?= $text ?></div>
                    <md-button class="md-primary" href="<?= $url ?>">
                        <?= format(
                            __n(
                                '{number} sentence', '{number} sentences',
                                $numSentences,
                                true
                            ),
                            array('number' => $numSentences)
                        ); ?>
                    </md-button>
                    <md-button ng-click="ctrl.showForm('<?= $hexId ?>')"
                               class="md-icon-button">
                        <md-icon aria-label="Add">add</md-icon>
                    </md-button>
                </md-list-item>
                <div id="sentences_<?= $hexId ?>" class="new-sentences"
                     ng-show="ctrl.sentencesAdded['<?= $hexId ?>']">
                    <div ng-repeat="sentence in ctrl.sentencesAdded['<?= $hexId ?>']"
                         class="new-sentence"
                         layout="row" layout-align="start center">
                        <md-button class="md-icon-button"
                                   ng-href="{{sentence.url}}">
                            <md-icon>forward</md-icon>
                        </md-button>
                        <div class="text" flex>{{sentence.text}}</div>
                    </div>
                </div>

                <div id="loader_<?= $hexId ?>" flex ng-show="false">
                    <md-progress-linear></md-progress-linear>
                </div>

                <form id="form_<?= $hexId ?>" class="sentence-form"
                      layout="column" flex ng-show="false"
                      ng-submit="ctrl.saveSentence('<?= $hexId ?>', '<?= $lang ?>')">
                    <md-input-container flex>
                        <label><? __('Sentence'); ?></label>
                        <input type="text" ng-disabled="ctrl.isAdding"
                               ng-model="ctrl.sentence['<?= $hexId ?>']">
                    </md-input-container>
                    <div layout="row" layout-align="end center">
                        <md-button class="md-raised"
                                   ng-disabled="ctrl.isAdding"
                                   ng-click="ctrl.hideForm('<?= $hexId ?>')">
                            <? __('Cancel') ?>
                        </md-button>
                        <md-button type="submit" class="md-raised md-primary"
                                   ng-disabled="ctrl.isAdding">
                            <? __('Submit') ?>
                        </md-button>
                    </div>
                </form>
                <?php
            }
            ?>
        </md-list>

        <?php
        $paginationUrl = array($lang);
        $pagination->display($paginationUrl);
        ?>
    </div>

</div>