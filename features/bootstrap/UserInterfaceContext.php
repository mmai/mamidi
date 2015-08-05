<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

use Mamidi\ClassifiedBundle\Twig\ClassifiedExtension;

/**
 * Defines application features from the specific context.
 */
class UserInterfaceContext extends MinkContext implements KernelAwareContext
{
    use KernelDictionary;

    private $fixturesContext;

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
     * @BeforeScenario
     */
    public function cleanDatabase(BeforeScenarioScope $scope)
    {
//        $container = $this->getContainer();
//        $registry = $container->get('doctrine');
//        $em = $registry->getManager();
//
//        $em->createQuery('DELETE FROM MamidiClassifiedBundle:Meal')->execute();
//        $em->createQuery('DELETE FROM MamidiClassifiedBundle:Reservation')->execute();


        $environment = $scope->getEnvironment();
        $this->fixturesContext = $environment->getContext('DoctrineFixturesContext');

        $loader = new Loader();

        $this->fixturesContext->loadFixtureClasses($loader, array(
                'Mamidi\UserBundle\DataFixtures\ORM\LoadUserData'
            ));

        /** @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $purger = new ORMPurger();
        $executor = new ORMExecutor($em, $purger);
        $executor->purge();
        $executor->execute($loader->getFixtures(), true);

    }

    /**
     * @Given I am a Host
     */
    public function iAmAHost()
    {
        $this->username = "mamie";

        $this->visit('/login');
        $this->fillField('username', $this->username);
        $this->fillField('password', "mamie");
        $this->pressButton('_submit');
    }

    /**
     * @Given I create a Meal with the formulas :formula1, :formula2, :formula3
     */
    public function iCreateAMealWithTheFormulas($formula1, $formula2, $formula3)
    {
        $this->visit('/meal/new');
        $this->fillField('mamidi_classifiedbundle_meal_starter', "tomates");
        $this->fillField('mamidi_classifiedbundle_meal_maincourse', "thon et riz");
        $this->fillField('mamidi_classifiedbundle_meal_dessert', "oeufs au lait");
        $this->fillField('mamidi_classifiedbundle_meal_numberOfGuests', "4");

        foreach (array("maincourse", "starter_maincourse", "maincourse_dessert", "complete") as $formula){
            $this->uncheckOption('mamidi_classifiedbundle_meal_formula_'.$formula);
        }
        foreach (array($formula1, $formula2, $formula3) as $formula){
            $this->checkOption('mamidi_classifiedbundle_meal_formula_'.$formula);
        }

        $this->pressButton('mamidi_classifiedbundle_meal_submit');
    }

    /**
     * @Then There should be a Meal with the formulas :formula1, :formula2, :formula3
     */
    public function thereShouldBeAMealWithTheFormulas($formula1, $formula2, $formula3)
    {
        $this->visit("/{$this->username}/meals");
        $results = $this->getSession()->getPage()->findAll("css", ".table.records_list.table tr");
        $result = $results[1];
        $values = $result->findAll("css", "td");
        assert($values[1]->getText() == "tomates");
        foreach (array($formula1, $formula2, $formula3) as $formula){
            assert(strpos($values[4]->getText(), (new ClassifiedExtension())->displayFormulaFilter($formula)) !== false);
        }
    }

}
