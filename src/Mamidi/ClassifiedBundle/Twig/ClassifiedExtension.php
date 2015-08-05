<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 05/08/15
 * Time: 16:28
 */

namespace Mamidi\ClassifiedBundle\Twig;

class ClassifiedExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('displayFormula', array($this, 'displayFormulaFilter')),
        );
    }

    public function displayFormulaFilter($formula)
    {
        $formulas = array(
            "maincourse" => "Plat",
            "starter_maincourse" => "Entrée + plat",
            "maincourse_dessert" => "Plat + dessert",
            "complete" => "Entrée + plat + dessert"
        );
        return $formulas[$formula];
    }

    public function getName()
    {
        return 'classified_extension';
    }
}