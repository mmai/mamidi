<?php

namespace spec\Mamidi\ClassifiedBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MealSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Mamidi\ClassifiedBundle\Entity\Meal');
    }

    public function it_should_enable_formula()
    {
        $this->enableFormula("complete");
    }

    public function it_should_get_formulas()
    {
        foreach (array("maincourse", "starter_maincourse", "maincourse_dessert", "complete") as $formula){
            $this->disableFormula($formula);
        }
        $this->enableFormula("starter_maincourse");
        $this->enableFormula("maincourse");
        $this->getFormulas()->shouldEqual(array("maincourse", "starter_maincourse"));
    }
}
