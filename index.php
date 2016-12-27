<?php
/**
 * CharZam Password creator creates 30 passwords with variable length (16-64 characters) from 5 groups.
 * @copyright Copyright (c) 2010, Peter Lembke, CharZam soft
 * @since 2016-12-27
 * @author Peter Lembke <peter@charzam.com>
 * @link http://charzam.com/
 * @license CharZam Password creator is distributed under the terms of the GNU General Public License
 * CharZam Password creator is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * CharZam Password creator is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with CharZam Password creator.    If not, see <http://www.gnu.org/licenses/>.
 */

class password {

    /**
     * Generates a password
     * @param int $length | wanted password length, give 0 for a random length 16-64 characters
     * @param int $maxGroupNumber | Gives a mix from 5 groups 0-4. Some sites accept only group 0-2.
     * @return string
     */
    public function generate($length = 0, $maxGroupNumber = 4) {
        if ($length === 0) {
            $length = $this->getRandomLength();
        }
        $groupString = $this->getGroupString($length);
        $groupStringArray = str_split($groupString);
        $result = '';
        foreach ($groupStringArray as $groupNumber) {
            $result = $result . $this->getRandomGroupCharacter($groupNumber, $maxGroupNumber);
        }

        $result = trim($result);

        return $result;
    }

    /**
     * A 16 character password is shamelessly small but some like it short.
     * @return mixed
     */
    protected function getRandomLength() {
        $length = $this->random(16,64);
        return $length;
    }

    /**
     * A string with group numbers.
     * This string makes it more likely that we later get a good mix of characters from different character groups.
     * Constructs a string with at least enough group numbers to cover the wanted password length.
     * Then shuffle the group numbers.
     * Then cut the string into the right length. (This can be an issue but then just try another password)
     * @param int $length
     * @return string
     */
    Protected function getGroupString($length = 64) {
        $start = '0000011111222333344';
        $copies = ceil($length / strlen($start));
        $result = str_repeat($start, $copies);
        $result = str_shuffle($result);
        $result = substr($result, 0, $length);
        return $result;
    }

    /**
     * Get a random character from the group of characters
     * @param $groupNumber
     * @param $maxGroupNumber
     * @return string
     */
    protected function getRandomGroupCharacter($groupNumber, $maxGroupNumber) {
        $group = $this->getGroupData($groupNumber, $maxGroupNumber);
        $length = strlen($group);
        if ($length <= 0) {
            return '';
        }

        $position = $this->random(0, $length-1);
        $character = substr($group, $position, 1);
        return $character;
    }

    protected function random($min = 0, $max = 0) {
        if (function_exists('random_int')) { // Requires PHP 7
            return random_int($min, $max);
        }
        return mt_rand($min,$max); // PHP 5 and later
    }

    /**
     * Often passwords require characters from different groups,
     * a CAPITAL letter, a number, a special character etc.
     * @param int $groupNumber | Get one of the lines
     * @param int $maxGroupNumber | In some cases special characters are not allowed
     * @return mixed
     */
    protected function getGroupData($groupNumber = 0, $maxGroupNumber = 4) {

        if ($groupNumber < 0) {
            $groupNumber = 0;
        }

        if ($groupNumber > $maxGroupNumber) {
            $groupNumber = $maxGroupNumber;
        }

        $data = array(
            0 => 'abcdefghijklmnopqrstuvwxyz',
            1 => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            2 => '0123456789',
            3 => '!#%&()=?+-*:;,._',
            4 => ' ',
        );

        return $data[$groupNumber];
    }

}

$password = new password();

$lengthText = '16-64';
$length = $_GET['length'];
if (empty($length)) {
    $length = 0;
}
if ($length > 0) {
    $lengthText = (string) $length;
}

$maxGroupNumber = $_GET['max_group_number'];
if (empty($maxGroupNumber)) {
    $maxGroupNumber = 4;
}

echo "<p>Password generator " .$lengthText. " characters from group 0-" . $maxGroupNumber . ".</p>";
for ($i = 30; $i > 0; $i--) {
    $result = $password->generate($length, $maxGroupNumber);
    echo "<pre>No#" . (31-$i) . " - " . $result . "</pre>";
}
echo "<p>Created by Peter Lembke CharZam soft 2016-12-27. License: Gnu GPL 3 or later</p>";
