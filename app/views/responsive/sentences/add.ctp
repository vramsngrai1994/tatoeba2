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

$this->set('title_for_layout', $pages->formatTitle(__('Add sentences', true)));

echo $responsive->js('sentences/add.ctrl.js');
?>

<div ng-controller="SentencesAddController as ctrl">
    <md-toolbar class="md-primary">
        <div class="md-toolbar-tools">
            Add a sentence
        </div>
    </md-toolbar>
    <md-content layout-padding class="md-whiteframe-1dp">
        <form ng-init="ctrl.init()">
            <md-autocomplete flex
                             md-selected-item-change="ctrl.onLanguageSelect(language)"
                             md-selected-item="ctrl.selectedItem"
                             md-search-text="ctrl.searchText"
                             md-items="language in ctrl.querySearch(ctrl.searchText)"
                             md-item-text="language.name"
                             md-min-length="1"
                             md-floating-label="Language (optional)">
                <md-item-template>
                    <span md-highlight-text="ctrl.searchText" md-highlight-flags="^i">{{language.name}}</span>
                </md-item-template>
                <md-not-found>
                    No results for <strong>{{ctrl.searchText}}</strong>.
                    <a href="http://en.wiki.tatoeba.org/articles/show/new-language-request" target="_blank">
                        Request a new language?
                    </a>
                </md-not-found>
            </md-autocomplete>

            <md-input-container class="md-block" flex-gt-sm>
                <label>Sentence</label>
                <input type="text" ng-model="ctrl.sentenceText"
                       ng-keyup="$event.keyCode == 13 && ctrl.addSentence()">
            </md-input-container>

            <div layout="row" layout-align="end center">
                <md-button class="md-raised md-primary"
                           ng-disabled="!ctrl.sentenceText"
                           ng-click="ctrl.addSentence()">
                    Submit
                </md-button>
            </div>

        </form>
    </md-content>

    <br>

    <md-toolbar class="md-accent">
        <div class="md-toolbar-tools">
            <h2>Sentences added</h2>
            <span flex></span>
            <md-progress-circular md-mode="indeterminate" md-diameter="32"
                                  class="md-accent md-hue-1"
                                  ng-show="ctrl.showLoader">
            </md-progress-circular>
        </div>

    </md-toolbar>
    <mg-content layout="column" layout-align="center center" class="md-whiteframe-1dp" layout-padding>
        <div id="new-sentences"></div>
    </mg-content>
</div>
