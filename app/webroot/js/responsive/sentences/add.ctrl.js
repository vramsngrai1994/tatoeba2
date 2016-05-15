(function() {
    'use strict';

    angular
        .module('app')
        .controller('SentencesAddController', ['$http', SentencesAddController]);

    function SentencesAddController($http) {
        var vm = this;

        vm.languages = null;
        vm.sentenceText = null;
        vm.languageCode = null;
        vm.showLoader = false;
        vm.selectedItem = null;

        vm.init = init;
        vm.querySearch = querySearch;
        vm.onLanguageSelect = onLanguageSelect;
        vm.addSentence = addSentence;


        function init() {
            $http.get('/api/languages').then(function(response) {
                vm.languages = response.data;
            });
        }

        function querySearch (query) {
            var lowercaseQuery = angular.lowercase(query);
            var result = [];
            for (var categoryKey in vm.languages) {
                var languages = vm.languages[categoryKey];

                for (var isoCode in languages) {
                    var language = languages[isoCode];
                    var lowercaseLanguage = angular.lowercase(language);
                    if (lowercaseLanguage.match(lowercaseQuery)) {
                        var item = {
                            code: isoCode,
                            name: language
                        };
                        result.push(item);
                    }
                }
            }
            return result;
        }

        function onLanguageSelect(language) {
            vm.languageCode = language.code;
        }

        function addSentence() {
            var body = {
                value: vm.sentenceText,
                selectedLang: vm.languageCode
            };

            vm.showLoader = true;

            $http.post('/sentences/add_an_other_sentence', body).then(
                function(response) {
                    var newSentences = angular.element(
                        document.querySelector('#new-sentences')
                    );
                    newSentences.prepend(response.data);
                    vm.sentenceText = null;
                    vm.showLoader = false;
                }
            );
        }
    }
})();