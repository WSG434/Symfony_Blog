<?php

namespace App\Entity;

use App\Repository\GoalConditionMasterGoalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoalConditionMasterGoalRepository::class)]
class GoalConditionMasterGoal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $goal_condition_id = null;

    #[ORM\Column]
    private ?int $master_goal_id = null;

    #[ORM\Column]
    private ?int $master_goal_engagement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGoalConditionId(): ?int
    {
        return $this->goal_condition_id;
    }

    public function setGoalConditionId(int $goal_condition_id): static
    {
        $this->goal_condition_id = $goal_condition_id;

        return $this;
    }

    public function getMasterGoalId(): ?int
    {
        return $this->master_goal_id;
    }

    public function setMasterGoalId(int $master_goal_id): static
    {
        $this->master_goal_id = $master_goal_id;

        return $this;
    }

    public function getMasterGoalEngagement(): ?int
    {
        return $this->master_goal_engagement;
    }

    public function setMasterGoalEngagement(int $master_goal_engagement): static
    {
        $this->master_goal_engagement = $master_goal_engagement;

        return $this;
    }
}
