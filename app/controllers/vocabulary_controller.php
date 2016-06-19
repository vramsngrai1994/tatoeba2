<?php
/**
 * Tatoeba Project, free collaborative creation of multilingual corpuses project
 * Copyright (C) 2016  HO Ngoc Phuong Trang <tranglich@gmail.com>
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

/**
 * Controller for vocabulary.
 *
 * @category Vocabulary
 * @package  Controllers
 * @author   HO Ngoc Phuong Trang <tranglich@gmail.com>
 * @license  Affero General Public License
 * @link     http://tatoeba.org
 */
class VocabularyController extends AppController
{
    public $uses = array('UsersVocabulary', 'User', 'Sentence', 'Vocabulary');
    public $components = array ('CommonSentence');

    /**
     * Before filter.
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();

        // setting actions that are available to everyone, even guests
        $this->Auth->allowedActions = array('of');
    }

    /**
     *
     */
    public function of($username, $lang = null)
    {
        $this->helpers[] = 'Pagination';
        $this->helpers[] = 'CommonModules';
        
        $userId = $this->User->getIdFromUsername($username);
        $this->paginate = $this->UsersVocabulary->getPaginatedVocabularyOf(
            $userId, $lang
        );
        $vocabulary = $this->paginate();

        $this->set('vocabulary', $vocabulary);
        $this->set('username', $username);
        $this->set('canEdit', $username == CurrentUser::get('username'));
    }


    /**
     *
     */
    public function add()
    {
    }


    /**
     *
     */
    public function add_sentences($lang = null)
    {
        $this->helpers[] = 'Pagination';
        $this->helpers[] = 'CommonModules';
        $this->helpers[] = 'Languages';

        $this->paginate = $this->Vocabulary->getPaginatedVocabulary($lang);
        $vocabulary = $this->paginate('Vocabulary');

        $this->set('vocabulary', $vocabulary);
        $this->set('lang', $lang);
    }


    /**
     *
     */
    public function save()
    {
        $lang = $_POST['lang'];
        $text = $_POST['text'];

        $result = $this->Vocabulary->addItem($lang, $text);
        $hexValue = unpack('H*', $result['id']);
        $result['id'] = str_pad($hexValue[1], 32, '0');
        $numSentences = $result['numSentences'];
        $result['numSentencesLabel'] = format(
            __n('{number} sentence', '{number} sentences', $numSentences, true),
            array('number' => $numSentences)
        );
        $this->set('result', $result);

        $this->layout = 'json';
    }


    /**
     *
     */
    public function remove($id)
    {
        $vocabularyId = hex2bin($id);

        $data = $this->UsersVocabulary->find(
            'first',
            array(
                'conditions' => array(
                    'vocabulary_id' => $vocabularyId,
                    'user_id' => CurrentUser::get('id')
                )
            )
        );

        if ($data) {
            $id = $data['UsersVocabulary']['id'];
            $this->UsersVocabulary->delete($id, false);
        }

        $this->set('vocabularyId', array('id' => $id));

        $this->layout = 'json';
    }


    /**
     *
     */
    public function save_sentence($vocabularyId)
    {
        $sentenceLang = $_POST['lang'];
        $sentenceText = $_POST['text'];
        $userId = CurrentUser::get('id');
        $username = CurrentUser::get('username');

        $isSaved = $this->CommonSentence->wrapper_save_sentence(
            $sentenceLang,
            $sentenceText,
            $userId,
            null,
            $username
        );

        $sentence = null;
        if ($isSaved) {
            $sentence = array(
                'id' => $this->Sentence->id,
                'text' => $sentenceText,
            );

            $this->Vocabulary->updateNumSentences($vocabularyId);
        }

        $this->set('sentence', $sentence);

        $this->layout = 'json';
    }

}
?>