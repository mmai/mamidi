# Created by henri at 02/08/15
Feature: Menu formula creation
  In order to describe my meal
  As a Host
  I need to be able to define the menu formulas available for my meal

  @domain @ui
  Scenario: Create a meal
    Given I am a Host
    And I create a Meal with the formulas "maincourse", "starter_maincourse", "maincourse_dessert"
    Then There should be a Meal with the formulas "maincourse", "starter_maincourse", "maincourse_dessert"