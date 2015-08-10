<?php
/**
 * Created by IntelliJ IDEA.
 * User: henri
 * Date: 05/08/15
 * Time: 16:28
 */

namespace Mamidi\ClassifiedBundle\Twig;

use Mamidi\ClassifiedBundle\Entity\Meal;

class ClassifiedExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('displayFormula', array($this, 'displayFormulaFilter')),
            new \Twig_SimpleFilter('formulaInformation', array($this, 'formulaInformationFilter')),
        );
    }

    public function displayFormulaFilter($formula)
    {
        $formulas = Meal::$formulas;
        if (!array_key_exists($formula, $formulas)) return "";
        return $formulas[$formula];
    }

    public function formulaInformationFilter($meal, $guest){
        $reservation = $meal->getReservationBy($guest);
        if (!$reservation) return "";
        return $this->displayFormulaFilter($reservation->getFormula());
    }

    public function getName()
    {
        return 'classified_extension';
    }
}