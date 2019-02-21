<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 07/02/2019
 * Time: 16:01
 */

namespace App\Controller;


use Behat\Transliterator\Transliterator;

trait HelperTrait
{
    public function slugify($text) {
        return Transliterator::transliterate($text);
    }
}
