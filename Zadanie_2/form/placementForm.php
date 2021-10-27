<form id="placementForm" name="placementForm" method="post" action="newPlacement.php<?php isset($person) ? '?person='.$person->getId() : ''  ?>">

    <input type="hidden" name="id" value="<?php echo isset($placement) ? $placement->getId() : null ?>">
    <input type="hidden" name="person_id" value="<?php echo isset($person) ? $person->getId() : null ?>">

    <label for="placing">placing</label>
    <input type="number" name="placing" id="placing" min="1" required="required" value="<?php echo isset($placement) ? $placement->getPlacing() : null ?>"><br>

    <label for="discipline">discipline</label>
    <input type="text" name="discipline" id="discipline" required="required" value="<?php echo isset($placement) ? $placement->getDiscipline() : null ?>"><br>


    <label for="oh_id">year</label>
    <select name="oh_id" id="oh_id" required="required">
        <?php
        require_once "classes/controllers/OlympicGameController.php";

        $olympicGameController = new OlympicGameController();
        $games = $olympicGameController->getAllGames();
        foreach ($games as $game){
            var_dump($game->getId());
            if (isset($placement) && ($game->getId() == $placement->getOhId())){
                echo "<option selected='selected' value='{$game->getId()}'>{$game->getYear()} {$game->getType()} {$game->getCity()}</option>";
            }
            else{
                echo "<option value='{$game->getId()}'>{$game->getYear()} {$game->getType()} {$game->getCity()}</option>";
            }
        }
        ?>
    </select>

    <input type="submit" value="submit" >
</form>
