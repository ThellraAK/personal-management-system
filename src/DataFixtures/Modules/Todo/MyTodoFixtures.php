<?php
namespace App\DataFixtures\Modules\Todo;

use App\Controller\Modules\ModulesController;
use App\DataFixtures\Providers\Modules\Todo;
use App\Entity\Modules\Issues\MyIssue;
use App\Entity\Modules\Todo\MyTodo;
use App\Entity\System\Module;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MyTodoFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Factory $faker
     */
    private $faker;

    public function __construct() {
        $this->faker = Factory::create('en');
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->addTodoGoals($manager);
        $this->addTodo($manager);
        $this->addIssueTodo($manager);
    }

    /**
     * @param ObjectManager $manager
     */
    private function addTodoGoals(ObjectManager $manager): void
    {
        $goals_module = $manager->getRepository(Module::class)->findOneBy([Module::FIELD_NAME => ModulesController::MODULE_NAME_GOALS]);

        foreach(Todo::ALL_TODO_GOALS as $index => $todo_with_elements) {

            foreach($todo_with_elements as $todo_name => $elements) {

                $display_on_dashboard = $this->faker->boolean;

                $my_todo = new MyTodo();
                $my_todo->setName($todo_name);
                $my_todo->setModule($goals_module);
                $my_todo->setDisplayOnDashboard($display_on_dashboard);

                $manager->persist($my_todo);
            }
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function addTodo(ObjectManager $manager): void
    {
        foreach(Todo::ALL_TODO as $index=> $todo_with_elements) {

            foreach($todo_with_elements as $todo_name => $elements) {

                $display_on_dashboard = $this->faker->boolean;

                $my_todo = new MyTodo();
                $my_todo->setName($todo_name);
                $my_todo->setDisplayOnDashboard($display_on_dashboard);

                $manager->persist($my_todo);
            }
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function addIssueTodo(ObjectManager $manager): void
    {
        $issue_module = $manager->getRepository(Module::class)->findOneBy([Module::FIELD_NAME => ModulesController::MODULE_NAME_ISSUES]);

        foreach(Todo::ALL_TODO_ISSUE as $issue_id => $todo_with_elements) {

            foreach($todo_with_elements as $todo_name => $elements) {

                $issue = $manager->getRepository(MyIssue::class)->findOneBy([MyIssue::FIELD_NAME_ID => $issue_id]);

                $display_on_dashboard = $this->faker->boolean;

                $my_todo = new MyTodo();
                $my_todo->setName($todo_name);
                $my_todo->setMyIssue($issue);
                $my_todo->setModule($issue_module);
                $my_todo->setDisplayOnDashboard($display_on_dashboard);

                $manager->persist($my_todo);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 20;
    }
}