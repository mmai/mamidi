<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

require_once __DIR__."/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php";

use Mamidi\UserBundle\Entity\HostUser;
use Mamidi\ClassifiedBundle\Entity\Meal;

/**
 * Defines application features from the specific context.
 */
class DomainContext implements Context, SnippetAcceptingContext
{

    private $dm;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I am a Host
     */
    public function iAmAHost()
    {
        $this->host = new HostUser();
        $this->host->setEmail("host@mamidi.org");
    }

    /**
     * @Given I create a Meal with the formulas :formula1, :formula2, :formula3
     */
    public function iCreateAMealWithTheFormulas($formula1, $formula2, $formula3)
    {
        $meal = new Meal();
        $meal->enableFormula($formula1);
        $meal->enableFormula($formula2);
        $meal->enableFormula($formula3);
        $this->host->addMeal($meal);
    }

    /**
     * @Then There should be a Meal with the formulas :formula1, :formula2, :formula3
     */
    public function thereShouldBeAMealWithTheFormulas($formula1, $formula2, $formula3)
    {
        $meals = $this->host->getMeals();
        assert($meals->count() > 0);
        $menus = $meals->first()->getMenus();

        assertEquals($menus, array($formula1, $formula2, $formula3));
    }

}
