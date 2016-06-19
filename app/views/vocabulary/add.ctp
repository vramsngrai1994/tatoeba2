<?php
$javascript->link('/js/responsive/vocabulary/add.ctrl.js', false);
?>

<div id="annexe_content">
    <?php echo $this->element('vocabulary/menu'); ?>

    <div class="section" layout="column" md-whiteframe="1">
        <h2><? __('Tips'); ?></h2>
        <p><?
        __(
            'Add vocabulary that you are learning. If your vocabulary does not '.
            'exist yet in Tatoeba, other contributors can add sentences for it.'
        );
        ?></p>
    </div>
</div>

<div ng-controller="VocabularyAddController as ctrl" id="main_content">

    <div class="section" layout="column" md-whiteframe="1">
        <h2><? __('Add vocabulary items'); ?></h2>
        <form ng-submit="ctrl.add()">
            <div layout="row">
                <div class="language" layout="column">
                    <label for="lang-select"><? __('Language'); ?></label>
                    <?php
                    $langArray = $this->Languages->profileLanguagesArray(
                        false, false
                    );
                    echo $form->select(
                        null,
                        $langArray,
                        null,
                        array(
                            'empty' => false,
                            'ng-model' => 'ctrl.data.lang',
                            'id' => 'lang-select'
                        ),
                        false
                    );
                    ?>
                </div>

                <md-input-container flex>
                    <label><? __('Vocabulary item'); ?></label>
                    <input type="text" ng-model="ctrl.data.text"
                           ng-disabled="ctrl.isAdding">
                </md-input-container>
            </div>

            <div layout="row" layout-align="center center">
                <md-button type="submit" class="md-raised md-primary"
                           ng-disabled="ctrl.isAdding || !ctrl.data.text || !ctrl.data.lang">
                    <? __('Add'); ?>
                </md-button>
            </div>
        </form>

    </div>

    <div class="section" md-whiteframe="1">
        <div layout="row">
            <h2 flex><? __('Vocabulary items added'); ?></h2>
            <md-progress-circular md-mode="indeterminate"
                                  md-diameter="32"
                                  ng-show="ctrl.isAdding">
            </md-progress-circular>
        </div>

        <md-list flex ng-show="ctrl.vocabularyAdded.length > 0">
            <md-list-item id="vocabulary_{{item.id}}"
                          ng-repeat="item in ctrl.vocabularyAdded">
                <img class="vocabulary-lang" ng-src="/img/flags/{{item.lang}}.png"/>
                <div class="vocabulary-text" flex>{{item.text}}</div>
                <md-button class="md-primary" href="{{item.url}}">
                    {{item.numSentencesLabel}}
                </md-button>
                <md-button ng-click="ctrl.remove(item.id)" class="md-icon-button">
                    <md-icon aria-label="Remove">delete</md-icon>
                </md-button>
            </md-list-item>
        </md-list>
    </div>

</div>
